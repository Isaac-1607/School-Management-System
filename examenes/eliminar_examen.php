<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/conexion.php';

// Verificar que solo CE pueda borrar
if (!isset($_SESSION['id_usuario']) || ($_SESSION['tipo_usuario'] ?? '') != 'CE') {
    header("Location: ../login.php");
    exit();
}

$folio = $_GET['folio'] ?? '';
if ($folio === '') {
    header("Location: consultar_ce.php?error=" . urlencode("Folio no proporcionado"));
    exit();
}

$error = '';
$mensaje_exito = '';

// ---- Procesar eliminación ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare("DELETE FROM examenes WHERE FolioExamen = :folio");
        $stmt->bindParam(':folio', $folio);
        $stmt->execute();
        $mensaje_exito = "✅ Examen eliminado correctamente.";
    } catch (PDOException $e) {
        $error = "❌ Error al eliminar: " . $e->getMessage();
    }
}
?>

<div class="container" style="margin-top:100px;">
    <div class="card shadow-lg border-0">
        <div class="card-body text-center">
            <h2 class="mb-4">🗑️ Eliminar Examen</h2>
            <p><strong>Folio:</strong> <?= htmlspecialchars($folio) ?></p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <a href="consultar_ce.php" class="btn btn-secondary mt-3">🔙 Regresar</a>
            <?php elseif (!empty($mensaje_exito)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($mensaje_exito) ?></div>
                <a href="consultar_ce.php" class="btn btn-success mt-3">✅ Volver a la lista</a>
            <?php else: ?>
                <div class="alert alert-warning">
                    ⚠️ Esta acción no se puede deshacer.<br>
                    ¿Seguro que deseas eliminar este examen?
                </div>
                <form method="post" class="d-inline">
                    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                </form>
                <a href="consultar_ce.php" class="btn btn-secondary">Cancelar</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
