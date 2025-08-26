<?php
// Iniciar sesión solo si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar autenticación y tipo de usuario
if (!isset($_SESSION['id_usuario']) || ($_SESSION['tipo_usuario'] != 'ES' && $_SESSION['tipo_usuario'] != 'CE')) {
    header("Location: /login.php");
    exit();
}

// Configurar título de página si no está definido
$page_title = $page_title ?? 'Panel del Sistema';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS externo -->
    <link rel="stylesheet" href="/instituto_heroes_U3/css/style.css">

    <link rel="stylesheet" href="/css/user-info.css">
</head>
<body>

<!-- 🔹 Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow fixed-top">
  <div class="container">
    <a class="navbar-brand" href="../index.php">Instituto Héroes</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Menú">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Inicio -->
        <li class="nav-item">
          <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="../index.php">Inicio</a>
        </li>

        <!-- Links para Estudiante -->
        <?php if ($_SESSION['tipo_usuario'] == 'ES'): ?>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'consultar_es.php' ? 'active' : ''; ?>" href="../examenes/consultar_es.php">Consultar</a>
          </li>
        <?php endif; ?>

        <!-- Links para Control Escolar -->
        <?php if ($_SESSION['tipo_usuario'] == 'CE'): ?>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'consultar_ce.php' ? 'active' : ''; ?>" href="../examenes/consultar_ce.php">Consultar CE</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'registrar_examen.php' ? 'active' : ''; ?>" href="../examenes/registrar_examen.php">Registrar</a>
          </li>
        <?php endif; ?>
      </ul>

      <!-- 🔹 Info Usuario -->
      <span class="navbar-text me-3 text-white">
        <?php echo htmlspecialchars($_SESSION['nombre']); ?> 
        (<?php echo ($_SESSION['tipo_usuario'] == 'ES') ? 'Estudiante' : 'Control Escolar'; ?>)
      </span>
      <a href="../logout.php" class="btn btn-outline-light btn-sm">Salir</a>
    </div>
  </div>
</nav>

<!-- 🔹 Espaciado para el contenido (por navbar fija) -->
<main class="container" style="margin-top: 100px;">
