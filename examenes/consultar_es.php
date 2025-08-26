<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] != 'ES') {
    header("Location: login.php");
    exit();
}

try {
    $stmt = $conn->prepare("SELECT * FROM examenes WHERE IDUsuario = ?");
    $stmt->execute([$_SESSION['id_usuario']]);
    $examenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = "Error al consultar los exámenes: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Exámenes Extraordinarios</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- CSS externo -->
  <link rel="stylesheet" href="/css/estilo.css">
  <style>
    body {
      background-image: url('/assets/images/fondo.jpg');
      background-size: cover;
      background-attachment: fixed;
    }
  </style>
</head>
<body>

<main class="container" style="margin-top:100px;">
  <div class="card shadow-lg border-0">
    <div class="card-body">
      <h2 class="text-center mb-4">📘 Mis Exámenes Extraordinarios</h2>

      <?php if(isset($error)): ?>
        <div class="alert alert-danger text-center">
          <?php echo $error; ?>
        </div>
      <?php elseif(empty($examenes)): ?>
        <div class="alert alert-info text-center">
          No tienes exámenes extraordinarios registrados.
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th>Asignatura</th>
                <th>Docente</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Aula</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($examenes as $examen): ?>
              <tr>
                <td><?php echo htmlspecialchars($examen['Asignatura']); ?></td>
                <td><?php echo htmlspecialchars($examen['DocenteAsignatura']); ?></td>
                <td><?php echo htmlspecialchars($examen['FechaAplicacion']); ?></td>
                <td><?php echo htmlspecialchars($examen['HoraAplicacion']); ?></td>
                <td><?php echo htmlspecialchars($examen['AulaAplicacion']); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
