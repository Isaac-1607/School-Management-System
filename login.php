<?php
session_start();
if(isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

$error_msg = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
$success_msg = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instituto Héroes - Iniciar Sesión</title>
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
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="registrarse.php">Registrarse</a></li>
          <li class="nav-item"><a class="nav-link active" href="login.php">Iniciar Sesión</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- 🔹 Contenido -->
  <main class="container" style="margin-top:100px;">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7 col-12">
        <div class="card shadow-lg border-0">
          <div class="card-body p-4">
            <h2 class="text-center mb-4">Acceso al Sistema</h2>

            <!-- Alertas -->
            <?php if(!empty($error_msg)): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <?php if(!empty($success_msg)): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <!-- Formulario -->
            <form id="loginForm" action="procesar_login.php" method="post" class="row g-3">
              
              <!-- ID Usuario -->
              <div class="col-12">
                <label for="id_usuario" class="form-label">ID de Usuario</label>
                <input type="text" class="form-control" id="id_usuario" name="id_usuario" 
                       required placeholder="Ej: 0000" pattern="[0-9]{4}" 
                       data-bs-toggle="tooltip" data-bs-title="Debe ser un número de 4 dígitos">
              </div>

              <!-- Password -->
              <div class="col-12">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" 
                       required placeholder="Ingrese su contraseña"
                       data-bs-toggle="tooltip" data-bs-title="Introduzca la contraseña registrada">
              </div>

              <!-- Botón -->
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success w-100">Iniciar Sesión</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </main>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Activar tooltips
    document.addEventListener("DOMContentLoaded", function(){
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTrigge
