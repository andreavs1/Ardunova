<?php
session_start();
$active_page = 'nosotros';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="ARDUNOVA - Aprendizaje práctico de Arduino, electrónica y robótica. Conoce nuestra historia, misión y equipo.">
  <title>Nosotros - ARDUNOVA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css?v=20261020-5">
</head>
<body>
<?php include 'includes/header.php'; ?>

<main class="container section-container py-4">
  <section class="page-heading text-center mb-5">
  <span class="section-kicker">Nuestra comunidad</span>
  <h1 class="section-title mb-3">Sobre ARDUNOVA</h1>
  <p class="lead mb-0 mx-auto page-intro">
    Somos un espacio dedicado a democratizar la enseñanza de la tecnología, facilitando el aprendizaje práctico de electrónica, programación y robótica mediante hardware libre.
  </p>
  </section>

  <!-- Misión, Visión y Valores -->
  <section class="mb-5">
    <div class="row g-4 justify-content-center">
      <div class="col-12 col-md-6 col-lg-4">
        <article class="card h-100">
          <div class="card-body text-center">
            <h3 class="mb-3">Misión</h3>
            <p>Acercar los cimientos de la tecnología abierta a estudiantes, brindando recursos claros para asimilar, estructurar y crear soluciones del mundo real.</p>
          </div>
        </article>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <article class="card h-100">
          <div class="card-body text-center">
            <h3 class="mb-3">Visión</h3>
            <p>Consolidarnos como el portal educativo de referencia en electrónica didáctica, eliminando las barreras de complejidad inicial en hardware libre.</p>
          </div>
        </article>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <article class="card h-100">
          <div class="card-body text-center">
            <h3 class="mb-3">Valores</h3>
            <p>Fomentamos el aprendizaje autodidacta, el trabajo colaborativo, la innovación abierta y el libre acceso a la información técnica.</p>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- Nuestra Historia -->
  <section class="mb-5">
    <h2 class="text-center mb-4">Nuestra Historia</h2>
    <div class="row g-4">
      <div class="col-12 col-md-4">
        <article class="card h-100">
          <div class="card-body text-center">
            <h3>El Origen</h3>
            <p>ARDUNOVA nació como un proyecto escolar/académico enfocado en simplificar los conceptos de diagramación lógica y montaje de circuitos básicos.</p>
          </div>
        </article>
      </div>
      <div class="col-12 col-md-4">
        <article class="card h-100">
          <div class="card-body text-center">
            <h3>El Crecimiento</h3>
            <p>Con el tiempo, expandimos nuestro catálogo de recursos, añadiendo esquemas visuales, guías descargables y librerías C++ listas para usar.</p>
          </div>
        </article>
      </div>
      <div class="col-12 col-md-4">
        <article class="card h-100">
          <div class="card-body text-center">
            <h3>El Futuro</h3>
            <p>Buscamos integrar nuevas tecnologías como IoT, automatización industrial básica y robótica móvil para seguir capacitando creadores.</p>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- Equipo / Integrantes (3 Arriba, 2 Abajo) -->
  <section class="mb-5">
    <h2 class="text-center mb-4">Equipo de Trabajo</h2>
    
    <!-- Primera fila: 3 integrantes -->
    <div class="row g-4 justify-content-center mb-4">
      <div class="col-12 col-sm-6 col-md-4">
        <article class="card text-center h-100">
          <div class="card-body">
            <div class="team-initial">
              CEO
            </div>
            <h3>Andrea Alvarado</h3>
            <p class="text-muted small">Liderazgo de Proyecto & UI/UX Designer</p>
          </div>
        </article>
      </div>

      <div class="col-12 col-sm-6 col-md-4">
        <article class="card text-center h-100">
          <div class="card-body">
            <div class="team-initial">
              DEV
            </div>
            <h3>Morena Cañás</h3>
            <p class="text-muted small">Desarrolladora Full-Stack & Creadora de Contenido</p>
          </div>
        </article>
      </div>

      <div class="col-12 col-sm-6 col-md-4">
        <article class="card text-center h-100">
          <div class="card-body">
            <div class="team-initial">
              DBA
            </div>
            <h3>Jazmin dos Santos</h3>
            <p class="text-muted small">Administradora de Bases de Datos (DBA)</p>
          </div>
        </article>
      </div>
    </div>

    <!-- Segunda fila: 2 integrantes centrados -->
    <div class="row g-4 justify-content-center">
      <div class="col-12 col-sm-6 col-md-4">
        <article class="card text-center h-100">
          <div class="card-body">
            <div class="team-initial">
              DOC
            </div>
            <h3>Mora Pacheco</h3>
            <p class="text-muted small">Gestora de Proyectos & Documentadora Técnica</p>
          </div>
        </article>
      </div>

      <div class="col-12 col-sm-6 col-md-4">
        <article class="card text-center h-100">
          <div class="card-body">
            <div class="team-initial">
              SEC
            </div>
            <h3>Joan Robledo</h3>
            <p class="text-muted small">Especialista en Ciberseguridad & Desarrollo de IA</p>
          </div>
        </article>
      </div>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>