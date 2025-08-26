<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- 🔹 Navbar Bootstrap -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
  <div class="container">
    <a class="navbar-brand" href="index.php">Instituto Héroes</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Menú">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php
        // Enlaces comunes
        $nav_links = [
            'index.php' => 'Inicio',
            'consultar.php' => 'Consultar',
            'registrar_examen.php' => 'Registrar'
        ];

        foreach ($nav_links as $page => $text) {
            $active = ($current_page == $page) ? 'active' : '';
            echo "<li class='nav-item'><a class='nav-link $active' href='$page'>$text</a></li>";
        }

        // Enlaces para CE
        if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'CE') {
            $ce_links = [
                'modificar.php' => 'Modificar',
                'eliminar.php' => 'Eliminar'
            ];

            foreach ($ce_links as $page => $text) {
                $active = ($current_page == $page) ? 'active' : '';
                echo "<li class='nav-item'><a class='nav-link $active' href='$page'>$text</a></li>";
            }
        }
        ?>
      </ul>

      <!-- 🔹 Autenticación / Usuario -->
      <div class="d-flex">
        <?php if (isset($_SESSION['tipo_usuario'])): ?>
          <span class="navbar-text me-3 text-white">
            <?php echo htmlspecialchars($_SESSION['nombre']); ?> 
            (<?php echo ($_SESSION['tipo_usuario'] == 'ES' ? 'Estudiante' : 'Control Escolar'); ?>)
          </span>
          <a href="logout.php" class="btn btn-outline-light btn-sm">Salir</a>
        <?php else: ?>
          <a href="registrarse.php" class="btn btn-primary btn-sm me-2">Registrarse</a>
          <a href="login.php" class="btn btn-outline-light btn-sm">Iniciar sesión</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
