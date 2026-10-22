<?php require_once __DIR__ . '/base.php'; ?>
<footer class="main-footer mt-auto">
  <div class="container py-5">
    <div class="row g-4">
      <div class="col-12 col-md-6 col-lg-4">
        <h2 class="footer-brand">ARDUNOVA</h2>
        <p class="footer-description mb-0">Plataforma dedicada a la enseñanza interactiva, proyectos de hardware libre y robótica.</p>
      </div>
      <div class="col-6 col-md-3 col-lg-2">
        <h3>Explorá</h3>
        <ul class="footer-links">
          <li><a href="<?= $base ?>index.php">Inicio</a></li>
          <li><a href="<?= $base ?>tutoriales.php">Tutoriales</a></li>
          <li><a href="<?= $base ?>proyectos.php">Proyectos</a></li>
          <li><a href="<?= $base ?>recursos.php">Recursos</a></li>
        </ul>
      </div>
      <div class="col-6 col-md-3 col-lg-3">
        <h3>Comunidad</h3>
        <ul class="footer-links">
          <li><a href="<?= $base ?>nosotros.php">Nosotros</a></li>
          <li><a href="<?= $base ?>login.php">Iniciar sesión</a></li>
        </ul>
      </div>
      <div class="col-12 col-lg-3">
        <h3>Contacto</h3>
        <ul class="footer-links">
          <li>ardunova.oficial@gmail.com</li>
          <li>Buenos Aires, Argentina</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container text-center">
      <p class="mb-0">&copy; <?= date('Y') ?> ARDUNOVA. Todos los derechos reservados.</p>
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
