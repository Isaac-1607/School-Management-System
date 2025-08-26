<?php
// Configurar título específico para esta página
$page_title = 'Registro de Exámenes Extraordinarios';
require_once __DIR__ . '/../includes/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($page_title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container" style="margin-top:100px;">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg border-0">
        <div class="card-body">
          <h3 class="text-center mb-4">📘 Registrar Examen Extraordinario</h3>

          <!-- Mensajes -->
          <?php if(isset($_GET['exito'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['exito']) ?></div>
          <?php endif; ?>

          <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
          <?php endif; ?>

          <!-- Formulario -->
          <form action="procesar_examen.php" method="post">
            <?php if($_SESSION['tipo_usuario'] == 'CE'): ?>
              <div class="mb-3">
                <label for="id_usuario" class="form-label">ID del Estudiante</label>
                <input type="text" class="form-control" id="id_usuario" name="id_usuario" required>
              </div>
            <?php else: ?>
              <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?>">
            <?php endif; ?>

            <div class="mb-3">
              <label for="asignatura" class="form-label">Asignatura</label>
              <input type="text" class="form-control" id="asignatura" name="asignatura" required>
            </div>

            <div class="mb-3">
              <label for="docente" class="form-label">Docente</label>
              <input type="text" class="form-control" id="docente" name="docente" required>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="aula" class="form-label">Aula</label>
              <input type="text" class="form-control" id="aula" name="aula" required>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Registrar Examen</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include __DIR__ . '/../includes/footer.php'; ?>
