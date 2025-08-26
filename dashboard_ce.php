<?php
session_start();

if(!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] != 'CE') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Control Escolar</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- CSS externo -->
  <link rel="stylesheet" href="/instituto_heroes_U3/css/style.css">
</head>
<body>

  <!-- 🔹 Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container">
      <a class="navbar-brand" href="index.php">Instituto Héroes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Menú">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="/instituto_heroes_U3/examenes/consultar_ce.php">Consultar</a></li>
          <li class="nav-item"><a class="nav-link" href="/instituto_heroes_U3/examenes/registrar_examen.php">Registrar</a></li>
          <li class="nav-item"><a class="nav-link" href="/instituto_heroes_U3/examenes/editar_examen.php">Modificar</a></li>
          <li class="nav-item"><a class="nav-link" href="/instituto_heroes_U3/examenes/eliminar_examen.php">Eliminar</a></li>
        </ul>

        <!-- 🔹 Info usuario -->
        <span class="navbar-text me-3 text-white">
          <?php echo htmlspecialchars($_SESSION['nombre']); ?> 
          (Control Escolar)
        </span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Salir</a>
      </div>
    </div>
  </nav>

  <!-- 🔹 Contenido principal -->
  <main class="container" style="margin-top:100px;">
    <div class="card shadow-lg border-0">
      <div class="card-body text-center">
        <h2 class="mb-3">
          Bienvenido/a 
          <?php echo htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido_paterno'] . ' ' . $_SESSION['apellido_materno']); ?>
        </h2>
        <p class="lead">Has ingresado como <strong>Personal de Control Escolar</strong>.</p>
      </div>
    </div>
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
