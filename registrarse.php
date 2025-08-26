<?php
session_start();
if(isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

require_once 'includes/conexion.php';

// Procesamiento del formulario si se envió
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validación y procesamiento aquí
    // ...
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Estudiante - Instituto Héroes</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- CSS externo -->
  <link rel="stylesheet" href="/instituto_heroes_U3/css/style.css">
</head>
<body>

<!-- 🔹 Navbar Bootstrap -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
  <div class="container">
    <a class="navbar-brand" href="#">Instituto Héroes</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Menú">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link active" href="registrarse.php">Registrarse</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- 🔹 Contenido principal -->
<div class="container mt-5 pt-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
          <h4>Formulario de Registro</h4>
        </div>
        <div class="card-body">

          <!-- Mensajes de error o éxito -->
          <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger">
              <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
          <?php endif; ?>

          <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">
              <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
          <?php endif; ?>

          <!-- Formulario Bootstrap -->

<form id="registroForm" action="procesar_registro.php" method="post" class="row g-3 justify-content-center">

  <!-- ID Usuario -->
  <div class="col-lg-4 col-md-6 col-12">
    <label for="id_usuario" class="form-label">ID de Usuario</label>
    <input type="text" class="form-control" id="id_usuario" name="id_usuario" 
           required placeholder="Ej: 1234" pattern="[0-9]{4}" 
           title="Debe ser un número de 4 dígitos"
           data-bs-toggle="tooltip" data-bs-placement="top"
           data-bs-title="Ingrese un número de 4 dígitos">
  </div>

  <!-- Nombre -->
  <div class="col-lg-4 col-md-6 col-12">
    <label for="nombre" class="form-label">Nombre(s)</label>
    <input type="text" class="form-control" id="nombre" name="nombre" 
           required placeholder="Ej: Juan Carlos" 
           pattern="[A-Za-záéíóúÁÉÍÓÚñÑ ]+" title="Solo letras y espacios"
           data-bs-toggle="tooltip" data-bs-placement="top"
           data-bs-title="Capture su(s) nombre(s) sin números">
  </div>

  <!-- Apellido Paterno -->
  <div class="col-lg-4 col-md-6 col-12">
    <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
    <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" 
           required placeholder="Ej: Pérez" 
           pattern="[A-Za-záéíóúÁÉÍÓÚñÑ]+" title="Solo letras"
           data-bs-toggle="tooltip" data-bs-placement="top"
           data-bs-title="Capture su apellido paterno">
  </div>

  <!-- Apellido Materno -->
  <div class="col-lg-4 col-md-6 col-12">
    <label for="apellido_materno" class="form-label">Apellido Materno</label>
    <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" 
           required placeholder="Ej: Gómez" 
           pattern="[A-Za-záéíóúÁÉÍÓÚñÑ]+" title="Solo letras"
           data-bs-toggle="tooltip" data-bs-placement="top"
           data-bs-title="Capture su apellido materno">
  </div>

  <!-- Edad -->
  <div class="col-lg-4 col-md-6 col-12">
    <label for="edad" class="form-label">Edad</label>
    <input type="number" class="form-control" id="edad" name="edad" 
           required min="15" max="99" placeholder="Ej: 20"
           data-bs-toggle="tooltip" data-bs-placement="top"
           data-bs-title="Edad mínima 15 años">
  </div>

  <!-- Sexo -->
  <div class="col-lg-4 col-md-6 col-12">
    <label for="sexo" class="form-label">Sexo</label>
    <select id="sexo" name="sexo" class="form-select" required
            data-bs-toggle="tooltip" data-bs-placement="top"
            data-bs-title="Seleccione su sexo">
      <option value="">Seleccione...</option>
      <option value="Masculino">Masculino</option>
      <option value="Femenino">Femenino</option>
      <option value="Otro">Otro</option>
    </select>
  </div>

  <!-- Email -->
  <div class="col-lg-4 col-md-6 col-12">
    <label for="email" class="form-label">Correo Electrónico</label>
    <input type="email" class="form-control" id="email" name="email" required 
           placeholder="Ej: ejemplo@dominio.com"
           data-bs-toggle="tooltip" data-bs-placement="top"
           data-bs-title="Ingrese un correo válido">
  </div>

  <!-- Teléfono -->
  <div class="col-lg-4 col-md-6 col-12">
    <label for="telefono" class="form-label">Teléfono</label>
    <input type="tel" class="form-control" id="telefono" name="telefono" required 
           placeholder="Ej: 5512345678" pattern="[0-9]{10}" title="10 dígitos"
           data-bs-toggle="tooltip" data-bs-placement="top"
           data-bs-title="Capture un número de 10 dígitos">
  </div>

  <!-- Contraseña -->
  <div class="col-lg-4 col-md-6 col-12">
    <label for="password" class="form-label">Contraseña</label>
    <input type="password" class="form-control" id="password" name="password" required 
           placeholder="Mínimo 8 caracteres"
           data-bs-toggle="tooltip" data-bs-placement="top"
           data-bs-title="Longitud mínima de 8 posiciones, con letras, números y un carácter especial (#,$,-,_,&,%)">
  </div>

  <!-- Confirmar Contraseña -->
  <div class="col-lg-4 col-md-6 col-12">
    <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required 
           placeholder="Repita su contraseña"
           data-bs-toggle="tooltip" data-bs-placement="top"
           data-bs-title="Repita la contraseña ingresada arriba">
  </div>

  <!-- Botón -->
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-success px-5">Registrarse</button>
  </div>
</form>

<!-- 🔹 Activar tooltips con JS -->
<script>
  document.addEventListener("DOMContentLoaded", function(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
  });
</script>

        </body>

</html>
