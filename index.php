<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['id_usuario']);
$nombre_usuario = $is_logged_in ? htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instituto Héroes - Página Principal</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- CSS externo -->
  <link rel="stylesheet" href="/instituto_heroes_U3/css/style.css">
</head>
<body>

  <!-- 🔹 Barra de navegación -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container">
      <a class="navbar-brand" href="index.php">Instituto Héroes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Menú">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">Inicio</a></li>
          

          <?php if ($is_logged_in): ?>
  <!-- Si el usuario está loggeado -->
  <li class="nav-item">
    <?php if ($_SESSION['tipo_usuario'] === 'ES'): ?>
      <a class="nav-link" href="dashboard_es.php">Dashboard</a>
    <?php elseif ($_SESSION['tipo_usuario'] === 'CE'): ?>
      <a class="nav-link" href="dashboard_ce.php">Dashboard</a>
    <?php endif; ?>
  </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  👤 <?= $nombre_usuario ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                  <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                </ul>
              </li>




          <?php else: ?>
              <!-- Si NO está loggeado -->
              <li class="nav-item"><a class="nav-link" href="registrarse.php">Registrarse</a></li>
              <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- 🔹 Carrusel -->
  <div id="carouselExample" class="carousel slide mt-5 pt-4" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="/instituto_heroes_U3/assets/images/img1.jpg" class="d-block w-100" alt="Imagen 1" data-bs-toggle="modal" data-bs-target="#modal1">
      </div>
      <div class="carousel-item">
        <img src="/instituto_heroes_U3/assets/images/img2.jpg" class="d-block w-100" alt="Imagen 2" data-bs-toggle="modal" data-bs-target="#modal2">
      </div>
      <div class="carousel-item">
        <img src="/instituto_heroes_U3/assets/images/img3.jpg" class="d-block w-100" alt="Imagen 3" data-bs-toggle="modal" data-bs-target="#modal3">
      </div>
      <div class="carousel-item">
        <img src="/instituto_heroes_U3/assets/images/img4.jpg" class="d-block w-100" alt="Imagen 4" data-bs-toggle="modal" data-bs-target="#modal4">
      </div>
      <div class="carousel-item">
        <img src="/instituto_heroes_U3/assets/images/img5.jpg" class="d-block w-100" alt="Imagen 5" data-bs-toggle="modal" data-bs-target="#modal5">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  <!-- 🔹 Modales de imágenes -->
  <div class="modal fade" id="modal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <img src="/instituto_heroes_U3/assets/images/img1.jpg" class="img-fluid" alt="Imagen 1">
        <div class="p-3">
          <h5>Evento Académico</h5>
          <p>Intercambio Internacional de Estudiantes.</p>
        </div>
      </div>
    </div>
  </div>
  <!-- (los otros modales igual que antes) -->

  <!-- 🔹 Sección de Cards -->
  
<section class="container my-5">
  <h2 class="text-center mb-4">Nuestros Servicios</h2>
  <div class="row g-4">

    <!-- Card 1 -->
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card h-100 shadow">
        <img src="/instituto_heroes_U3/assets/images/Biblioteca.jpg" class="card-img-top" alt="Biblioteca">
        <div class="card-body">
          <h5 class="card-title">Biblioteca</h5>
          <p class="card-text">Accede a recursos digitales y físicos para tu formación académica.</p>
          <a href="#" class="btn btn-primary">Ver más</a>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card h-100 shadow">
        <img src="/instituto_heroes_U3/assets/images/Fondo.jpg" class="card-img-top" alt="Orientación Académica">
        <div class="card-body">
          <h5 class="card-title">Orientación Académica</h5>
          <p class="card-text">Recibe asesoría personalizada para tu desarrollo académico.</p>
          <a href="#" class="btn btn-primary">Ver más</a>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card h-100 shadow">
        <img src="/instituto_heroes_U3/assets/images/Cultura.jpg" class="card-img-top" alt="Extensión Universitaria">
        <div class="card-body">
          <h5 class="card-title">Extensión Universitaria</h5>
          <p class="card-text">Participa en actividades culturales y de vinculación con la sociedad.</p>
          <a href="#" class="btn btn-primary">Ver más</a>
        </div>
      </div>
    </div>

  </div>
</section>




  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
