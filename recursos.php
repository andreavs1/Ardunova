<?php
session_start();
$active_page = 'recursos';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="ARDUNOVA - Aprendizaje práctico de Arduino, electrónica y robótica.">
  <title>Recursos - ARDUNOVA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css?v=20261020-5">
</head>
<body>
<?php include 'includes/header.php'; ?>
<main class="container section-container">
<div class="page-heading">
  <span class="section-kicker">Material para tus proyectos</span>
  <h1 class="section-title">Recursos descargables</h1>
  <p>Consultá guías y materiales de apoyo para acompañar tu aprendizaje.</p>
</div>
<div class="row g-4">
<div class="col-12 col-sm-6 col-lg-4"><article class="card resource-card">
<div class="card-body text-center">
<h3>Guía Arduino PDF</h3>
<p>Manual conceptual completo que detalla la arquitectura del hardware libre y conexiones eléctricas básicas.</p>
<a class="btn btn-gradient mt-1 w-100" href="assets/img/arduino.jpg" download>Descargar PDF</a>
</div>
</article></div><div class="col-12 col-sm-6 col-lg-4"><article class="card resource-card">
<div class="card-body text-center">
<h3>Librerías de Sensores</h3>
<p>Compilado de controladores zip listos para importar directamente en tu entorno Arduino IDE local.</p>
<a class="btn btn-gradient mt-1 w-100" href="assets/img/servo.jpg" download>Descargar ZIP</a>
</div>
</article></div><div class="col-12 col-sm-6 col-lg-4"><article class="card resource-card">
<div class="card-body text-center">
<h3>Manual de Código C++</h3>
<p>Vademécum detallado con explicaciones sintácticas exactas de comandos estructurados avanzados.</p>
<a class="btn btn-gradient mt-1 w-100" href="assets/img/variables.png" download>Descargar DOC</a>
</div>
</article></div><div class="col-12 col-sm-6 col-lg-4"><article class="card resource-card">
<div class="card-body text-center">
<h3>Esquemas de Conexión</h3>
<p>Infografías de alta resolución detallando el patillaje y descripción técnica de componentes comunes.</p>
<a class="btn btn-gradient mt-1 w-100" href="assets/img/partes-arduino.jpg" download>Descargar PNG</a>
</div>
</article></div></div>
</main>
<?php include 'includes/footer.php'; ?>
</body>
</html>
