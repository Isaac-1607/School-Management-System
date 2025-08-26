<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../includes/conexion.php';

// ---- Permisos: solo CE ----
if (!isset($_SESSION['id_usuario']) || ($_SESSION['tipo_usuario'] ?? '') !== 'CE') {
    header('Location: ../login.php');
    exit();
}

$folio = $_GET['folio'] ?? '';
if ($folio === '') {
    header('Location: consultar_ce.php?error=' . urlencode('Folio no proporcionado'));
    exit();
}

$error = '';
$mensaje_exito = '';

// ---- Procesar actualización ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asignatura = trim($_POST['asignatura'] ?? '');
    $docente    = trim($_POST['docente'] ?? '');
    $fecha      = trim($_POST['fecha'] ?? '');
    $hora       = trim($_POST['hora'] ?? '');
    $aula       = trim($_POST['aula'] ?? '');

    if ($asignatura === '' || $docente === '' || $fecha === '' || $hora === '' || $aula === '') {
        $error = 'Todos los campos son obligatorios.';
    } elseif (!DateTime::createFromFormat('Y-m-d', $fecha)) {
        $error = 'Formato de fecha inválido (use YYYY-MM-DD).';
    } elseif (!DateTime::createFromFormat('H:i', $hora)) {
        $error = 'Formato de hora inválido (use HH:MM).';
    }

    if ($error === '') {
        try {
            $stmt = $conn->prepare("
                UPDATE examenes
                SET Asignatura = :asignatura,
                    DocenteAsignatura = :docente,
                    FechaAplicacion = :fecha,
                    HoraAplicacion = :hora,
                    AulaAplicacion = :aula
                WHERE FolioExamen = :folio
            ");
            $stmt->bindParam(':asignatura', $asignatura);
            $stmt->bindParam(':docente', $docente);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':hora', $hora);
            $stmt->bindParam(':aula', $aula);
            $stmt->bindParam(':folio', $folio);
            $stmt->execute();

            // Mensaje de éxito en la misma página
            $mensaje_exito = '✅ Guardado con éxito';
        } catch (PDOException $e) {
            $error = 'Error al actualizar: ' . $e->getMessage();
        }
    }
}

// ---- Obtener datos del examen ----
try {
    $stmt = $conn->prepare("SELECT * FROM examenes WHERE FolioExamen = :folio");
    $stmt->bindParam(':folio', $folio);
    $stmt->execute();
    $examen = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$examen) {
        header('Location: consultar_ce.php?error=' . urlencode('Examen no encontrado'));
        exit();
    }
} catch (PDOException $e) {
    header('Location: consultar_ce.php?error=' . urlencode('Error al cargar el examen'));
    exit();
}

// Normalizar fecha y hora
$fechaValue = !empty($examen['FechaAplicacion']) ? date('Y-m-d', strtotime($examen['FechaAplicacion'])) : '';
$horaValue  = !empty($examen['HoraAplicacion']) ? substr($examen['HoraAplicacion'], 0, 5) : '';

$page_title = 'Editar Examen (Folio ' . htmlspecialchars($folio) . ')';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container" style="margin-top:100px;">
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h2 class="mb-3">✏️ Editar Examen</h2>
            <p><strong>Folio:</strong> <?= htmlspecialchars($folio) ?></p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (!empty($mensaje_exito)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($mensaje_exito) ?></div>
            <?php endif; ?>

            <form method="post" action="editar_examen.php?folio=<?= urlencode($folio) ?>">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="asignatura" class="form-label">Asignatura</label>
                        <input type="text" id="asignatura" name="asignatura"
                               class="form-control"
                               value="<?= htmlspecialchars($examen['Asignatura'] ?? '') ?>" required>
                    </div>

                    <div class="col-12">
                        <label for="docente" class="form-label">Docente</label>
                        <input type="text" id="docente" name="docente"
                               class="form-control"
                               value="<?= htmlspecialchars($examen['DocenteAsignatura'] ?? '') ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="fecha" class="form-label">Fecha de aplicación</label>
                        <input type="date" id="fecha" name="fecha"
                               class="form-control"
                               value="<?= htmlspecialchars($fechaValue) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="hora" class="form-label">Hora de aplicación</label>
                        <input type="time" id="hora" name="hora"
                               class="form-control"
                               value="<?= htmlspecialchars($horaValue) ?>" required>
                    </div>

                    <div class="col-12">
                        <label for="aula" class="form-label">Aula</label>
                        <input type="text" id="aula" name="aula"
                               class="form-control"
                               value="<?= htmlspecialchars($examen['AulaAplicacion'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">💾 Guardar cambios</button>
                    <a href="consultar_ce.php" class="btn btn-secondary">❌ Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
