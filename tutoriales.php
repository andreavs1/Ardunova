<?php
session_start();
$active_page = 'tutoriales';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="ARDUNOVA - Aprendizaje práctico de Arduino, electrónica y robótica.">
  <title>Tutoriales - ARDUNOVA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css?v=20261020-5">
</head>
<body>
  <?php include __DIR__ . '/includes/header.php';?>

  <main>
    <section class="container section-container pb-0">
      <div class="page-heading">
        <span class="section-kicker">Aprendizaje paso a paso</span>
        <h1 class="section-title">Tutoriales de Arduino</h1>
        <p>Elegí tu nivel y aprendé electrónica, programación y robótica con guías prácticas.</p>
      </div>
    </section>

    <section class="container section-container">
      <div class="section-heading">
        <div>
          <span class="section-kicker">Encontrá tu punto de partida</span>
          <h2 class="section-title mb-0">Niveles de aprendizaje</h2>
        </div>
      </div>
  
      <div class="row g-4">
        <!-- Nivel Principiante -->
        <div class="col-12 col-sm-6 col-lg-4">
          <article class="card h-100">
            <div class="card-image">
              <img src="assets/img/principiante.png" alt="Principiante" class="card-img-top">
            </div>
            <div class="card-body">
              <span class="tag-nivel principiante">Principiante</span>
              <h3>Nivel principiante</h3>
              <p>Aprende los conceptos principales de Arduino, el entorno de programación y los primeros proyectos.</p>
              <a class="btn btn-gradient mt-1 w-100" href="principiantes/principiantes.php">
                Comenzar 
              </a>
            </div>
          </article>
        </div>

        <!-- Nivel Intermedio -->
        <div class="col-12 col-sm-6 col-lg-4">
          <article class="card h-100">
            <div class="card-image">
              <img src="assets/img/intermedio.jpg" alt="Intermedio" class="card-img-top">
            </div>
            <div class="card-body">
              <span class="tag-nivel intermedio">Intermedio</span>
              <h3>Nivel intermedio</h3>
              <p>Trabaja con sensores, entradas analógicas, motores y diferentes componentes electrónicos.</p>
              <a class="btn btn-gradient mt-1 w-100" href="intermedio/intermedio.php">
                Comenzar
              </a>
            </div>
          </article>
        </div>

        <!-- Nivel Avanzado -->
        <div class="col-12 col-sm-6 col-lg-4">
          <article class="card h-100">
            <div class="card-image">
              <img src="assets/img/avanzado.png" alt="Avanzado" class="card-img-top">
            </div>
            <div class="card-body">
              <span class="tag-nivel avanzado">Avanzado</span>
              <h3>Nivel avanzado</h3>
              <p>Aprende comunicaciones, librerías y proyectos más completos utilizando Arduino.</p>
              <a class="btn btn-gradient mt-1 w-100" href="avanzado/avanzado.php">
                Comenzar
              </a>
            </div>
          </article>
        </div> 
      </div>
    </section> 

  </main>

  <?php include 'includes/chatbot.php'; ?>
  <?php include 'includes/footer.php';?>

</body>
</html>