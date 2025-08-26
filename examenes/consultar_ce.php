<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/conexion.php';

// Verificar permisos CE
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] != 'CE') {
    header("Location: login.php");
    exit();
}

$examenes = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['id_usuario'])) {
    try {
        $stmt = $conn->prepare("SELECT * FROM examenes WHERE IDUsuario = ?");
        $stmt->execute([$_POST['id_usuario']]);
        $examenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        $error = "Error al consultar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultar Exámenes por Alumno</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- CSS propio -->
  <style>
    body {
      background-image: url('/assets/images/fondo.jpg');
      background-size: cover;
      background-attachment: fixed;
    }
  </style>
</head>


<body>


<main class="container my-5">
  <div class="card shadow-lg border-0">
    <div class="card-body">
      <h2 class="text-center mb-4">Consultar Exámenes por Alumno</h2>

      <!-- Formulario -->
      <form method="POST" class="row g-3 justify-content-center mb-4">
        <div class="col-md-6">
          <label for="id_usuario" class="form-label">ID Usuario:</label>
          <input type="text" name="id_usuario" id="id_usuario" class="form-control" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100">Consultar</button>
        </div>
      </form>

      <!-- Errores -->
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <!-- Resultados -->
      <?php if (!empty($examenes)): ?>
        <div class="table-responsive">
          <table class="table table-striped table-bordered align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>Asignatura</th>
                <th>Docente</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Aula</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($examenes as $examen): ?>
              <tr>
                <td><?= htmlspecialchars($examen['Asignatura']); ?></td>
                <td><?= htmlspecialchars($examen['DocenteAsignatura']); ?></td>
                <td><?= htmlspecialchars($examen['FechaAplicacion']); ?></td>
                <td><?= htmlspecialchars($examen['HoraAplicacion']); ?></td>
                <td><?= htmlspecialchars($examen['AulaAplicacion']); ?></td>
                <td>
                  <a href="editar_examen.php?folio=<?= urlencode($examen['FolioExamen']); ?>" 
                     class="btn btn-sm btn-warning me-2">Editar</a>
                  <a href="eliminar_examen.php?folio=<?= urlencode($examen['FolioExamen']); ?>"
                     class="btn btn-sm btn-danger"
                     onclick="return confirm('¿Seguro que quieres eliminar este examen?');">
                     Eliminar
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <div class="alert alert-info">No se encontraron exámenes para este IDUsuario.</div>
      <?php endif; ?>
    </div>
  </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
