<?php
require_once __DIR__ . '/base.php';
$active_page = $active_page ?? '';
$usuario_sesion = $_SESSION['usuario'] ?? null;
?>
<header class="main-header">
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="<?= $base ?>index.php" aria-label="ARDUNOVA - Inicio">
        <img src="<?= $base ?>assets/img/logo.jpg" alt="Logo de ARDUNOVA" class="brand-logo">
      </a>

      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Abrir menú">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
          <li class="nav-item"><a class="nav-link <?= $active_page === 'inicio' ? 'active' : '' ?>" href="<?= $base ?>index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link <?= $active_page === 'tutoriales' ? 'active' : '' ?>" href="<?= $base ?>tutoriales.php">Tutoriales</a></li>
          <li class="nav-item"><a class="nav-link <?= $active_page === 'proyectos' ? 'active' : '' ?>" href="<?= $base ?>proyectos.php">Proyectos</a></li>
          <li class="nav-item"><a class="nav-link <?= $active_page === 'recursos' ? 'active' : '' ?>" href="<?= $base ?>recursos.php">Recursos</a></li>
          <li class="nav-item"><a class="nav-link <?= $active_page === 'donaciones' ? 'active' : '' ?>" href="<?= $base ?>donaciones.php">Donaciones</a></li>
          <li class="nav-item"><a class="nav-link <?= $active_page === 'nosotros' ? 'active' : '' ?>" href="<?= $base ?>nosotros.php">Nosotros</a></li>
          <?php if ($usuario_sesion): ?>
            <li class="nav-item dropdown ms-lg-2">
              <a class="nav-link dropdown-toggle user-link" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= htmlspecialchars($usuario_sesion) ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="<?= $base ?>perfil.php">Mi perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?= $base ?>logout.php">Cerrar sesión</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item ms-lg-2 mt-2 mt-lg-0"><a class="btn btn-gradient btn-sm px-3" href="<?= $base ?>login.php">Iniciar sesión</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>
