<?php
session_start();
$active_page = 'inicio';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Aprendé Arduino, electrónica y robótica con tutoriales prácticos y proyectos paso a paso en ARDUNOVA.">
  <title>ARDUNOVA | Aprendé Arduino creando</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css?v=20261021-1">
</head>
<body>
<?php include 'includes/header.php'; ?>

<main>
<section class="hero">
  <div class="container py-lg-3">
    <div class="row align-items-center g-4 g-lg-5">
      <div class="col-12 col-lg-5 hero-content">
        <span class="hero-badge badge rounded-pill">Electrónica · Arduino · Robótica</span>
        <h1>De la primera idea a tu próximo <span class="highlight">proyecto.</span></h1>
        <p>Aprendé Arduino con explicaciones claras, prácticas guiadas y proyectos que podés construir paso a paso.</p>
        <div class="hero-buttons d-flex flex-column flex-sm-row">
          <a class="btn btn-gradient btn-lg" href="tutoriales.php">Empezar a aprender <span aria-hidden="true">→</span></a>
          <a class="btn btn-outline-cyan btn-lg" href="proyectos.php">Ver proyectos</a>
        </div>
        <ul class="hero-highlights d-flex flex-wrap" aria-label="Características de ARDUNOVA">
          <li>Sin experiencia previa</li>
          <li>Aprendizaje práctico</li>
          <li>A tu ritmo</li>
        </ul>
      </div>

      <div class="col-12 col-lg-7 hero-image">
        <div id="heroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Arduino"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Robótica"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Proyectos"></button>
          </div>

          <div class="carousel-inner rounded-4 overflow-hidden shadow-lg">
            <div class="carousel-item active">
              <img src="assets/img/ardui2.png" class="d-block w-100" alt="Placa Arduino Uno">
              <div class="carousel-caption">
                <span>Arduino desde cero</span>
              </div>
            </div>
            <div class="carousel-item">
              <img src="assets/img/walle.jpg" class="d-block w-100" alt="Proyecto de robótica">
              <div class="carousel-caption">
                <span>Robótica y creatividad</span>
              </div>
            </div>
            <div class="carousel-item">
              <img src="assets/img/proyectos.jpg" class="d-block w-100" alt="Proyecto práctico">
              <div class="carousel-caption">
                <span>Proyectos para aprender haciendo</span>
              </div>
            </div>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" aria-label="Anterior">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" aria-label="Siguiente">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="home-benefits" aria-label="Qué encontrás en ARDUNOVA">
  <div class="container">
    <div class="row row-cols-1 row-cols-sm-3 g-3">
      <div class="col">
        <div class="home-benefit">
          <span class="home-benefit-number">01</span>
          <div><strong>Guías claras</strong><span>Conceptos explicados paso a paso</span></div>
        </div>
      </div>
      <div class="col">
        <div class="home-benefit">
          <span class="home-benefit-number">02</span>
          <div><strong>Práctica real</strong><span>Proyectos para aprender haciendo</span></div>
        </div>
      </div>
      <div class="col">
        <div class="home-benefit">
          <span class="home-benefit-number">03</span>
          <div><strong>Tu propio ritmo</strong><span>Empezá por el nivel que necesitás</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="container section-container">
  <div class="section-heading">
    <div>
      <span class="section-kicker">Aprendé haciendo</span>
      <h2 class="section-title mb-1">Ideas que podés construir</h2>
      <p class="section-subtitle mb-0">Proyectos guiados para construir, practicar y animarte a experimentar.</p>
    </div>
    <a class="home-text-link" href="proyectos.php">Ver todos los proyectos <span aria-hidden="true">→</span></a>
  </div>

  <div id="projectsCarousel" class="carousel slide project-carousel" data-bs-ride="false" aria-label="Proyectos destacados">
    <div class="carousel-indicators project-indicators">
      <button type="button" data-bs-target="#projectsCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Primer grupo de proyectos"></button>
      <button type="button" data-bs-target="#projectsCarousel" data-bs-slide-to="1" aria-label="Segundo grupo de proyectos"></button>
    </div>
    <div class="carousel-inner">

      <div class="carousel-item active">
        <div class="row g-4">
          <div class="col-12 col-md-6">
            <article class="card home-project-card h-100">
              <div class="card-image">
                <img alt="Semáforo inteligente" src="assets/img/semaforo.png"/>
              </div>
              <div class="card-body">
                <span class="tag-nivel principiante">Principiante</span>
                <h3>Semáforo inteligente</h3>
                <p>Estructuración básica de temporizaciones de luces viales.</p>
                <a class="btn btn-gradient mt-1 w-100" href="proyecto/SemaforoA.php">Ver proyecto <span aria-hidden="true">→</span></a>
              </div>
            </article>
          </div>

          <div class="col-12 col-md-6">
            <article class="card home-project-card h-100">
              <div class="card-image">
                <img alt="Robot seguidor de línea" src="assets/img/robot-seguidor-linea.png"/>
              </div>
              <div class="card-body">
                <span class="tag-nivel intermedio">Intermedio</span>
                <h3>Auto Seguidor de Línea</h3>
                <p>Diseño de un robot móvil autónomo con sensores infrarrojos.</p>
                <a class="btn btn-gradient mt-1 w-100" href="proyecto/seguidorlinea.php">Ver proyecto <span aria-hidden="true">→</span></a>
              </div>
            </article>
          </div>
        </div>
      </div>

      <div class="carousel-item">
        <div class="row g-4">
          <div class="col-12 col-md-6">
            <article class="card home-project-card h-100">
              <div class="card-image">
                <img alt="Pantalla LCD" src="assets/img/lcd.jpg"/>
              </div>
              <div class="card-body">
                <span class="tag-nivel principiante">Principiante</span>
                <h3>Pantalla LCD</h3>
                <p>Conocé cómo mostrar información en una pantalla usando Arduino.</p>
                <a class="btn btn-gradient mt-1 w-100" href="proyecto/lcddinamica.php">Ver proyecto <span aria-hidden="true">→</span></a>
              </div>
            </article>
          </div>

          <div class="col-12 col-md-6">
            <article class="card home-project-card h-100">
              <div class="card-image">
                <img alt="Sensor ultrasónico" src="assets/img/ultrasonico.jpg"/>
              </div>
              <div class="card-body">
                <span class="tag-nivel intermedio">Intermedio</span>
                <h3>Sensor Ultrasónico</h3>
                <p>Aprendé a medir distancias y usar sensores en tus proyectos.</p>
                <a class="btn btn-gradient mt-1 w-100" href="proyecto/SensorUltrasonico.php">Ver proyecto <span aria-hidden="true">→</span></a>
              </div>
            </article>
          </div>
        </div>
      </div>

    </div>

    <button class="carousel-control-prev project-control" type="button" data-bs-target="#projectsCarousel" data-bs-slide="prev" aria-label="Proyectos anteriores">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next project-control" type="button" data-bs-target="#projectsCarousel" data-bs-slide="next" aria-label="Proyectos siguientes">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</section>

<section class="learning-section">
  <div class="container">
    <div class="section-heading">
      <div>
        <span class="section-kicker">Tu próximo paso</span>
        <h2 class="section-title mb-1">Aprendé a tu ritmo</h2>
        <p class="section-subtitle mb-0">Un recorrido pensado para acompañarte desde tus primeros circuitos.</p>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-12 col-md-4">
        <a class="learning-card" href="principiantes/principiantes.php">
          <div class="learning-card-image">
            <img src="assets/img/principiante.png" alt="Placa Arduino para comenzar desde cero">
            <span>01 · Fundamentos</span>
          </div>
          <div class="learning-card-body">
            <h3>Empezá desde cero</h3>
            <p>Conocé Arduino, sus componentes y los primeros conceptos de programación.</p>
            <span class="learning-card-link">Explorar nivel <span aria-hidden="true">→</span></span>
          </div>
        </a>
      </div>
      <div class="col-12 col-md-4">
        <a class="learning-card" href="intermedio/intermedio.php">
          <div class="learning-card-image">
            <img src="assets/img/intermedio.jpg" alt="Proyecto electrónico de nivel intermedio">
            <span>02 · Práctica</span>
          </div>
          <div class="learning-card-body">
            <h3>Creá proyectos útiles</h3>
            <p>Combiná sensores, condiciones y actuadores para dar vida a tus ideas.</p>
            <span class="learning-card-link">Seguir aprendiendo <span aria-hidden="true">→</span></span>
          </div>
        </a>
      </div>
      <div class="col-12 col-md-4">
        <a class="learning-card" href="avanzado/avanzado.php">
          <div class="learning-card-image">
            <img src="assets/img/avanzado.png" alt="Proyecto avanzado de electrónica y robótica">
            <span>03 · Innovación</span>
          </div>
          <div class="learning-card-body">
            <h3>Llevá tus ideas más lejos</h3>
            <p>Explorá comunicación, pantallas y proyectos integradores más desafiantes.</p>
            <span class="learning-card-link">Descubrir avanzado <span aria-hidden="true">→</span></span>
          </div>
        </a>
      </div>
    </div>

    <div class="home-cta">
      <div>
        <span class="home-cta-eyebrow">Tu próximo proyecto empieza acá</span>
        <h2>La mejor forma de aprender tecnología es creando.</h2>
      </div>
      <a class="btn btn-light" href="tutoriales.php">Explorar tutoriales <span aria-hidden="true">→</span></a>
    </div>
  </div>
</section>
</main>

<?php include 'includes/chatbot.php'; ?>
<?php include 'includes/footer.php'; ?>
</body>
</html>
