<?php
require_once __DIR__ . '/../includes/base.php';
session_start();
$active_page = 'tutoriales';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nivel Intermedio - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">

</head>

<body> 

<?php include __DIR__ . '/../includes/header.php'; ?>

<main>

<!-- SECCIÓN DE ENCABEZADO Y BUSCADOR -->
<section class="container section-container">
  <div class="level-page-header">
    <div>
      <span class="section-kicker">Ruta de aprendizaje · 02</span>
      <h1 class="section-title mb-2">Nivel intermedio</h1>
      <p class="mb-0">Combiná componentes y lógica para construir proyectos más completos.</p>
    </div>
    <div class="level-search">
      <label class="form-label" for="inputBuscador">Buscar un tutorial</label>
      <div class="input-group rounded-2 overflow-hidden buscador-ardunova">
        <span class="input-group-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
          </svg>
        </span>
        <input 
          type="text" 
          id="inputBuscador" 
          class="form-control"
          placeholder="Buscar tutorial..." 
          aria-label="Buscar tutorial por nombre"
          onkeyup="filtrarTutoriales()"
        >
      </div>
    </div>
  </div>
</section>

<!-- GRILLA DE TUTORIALES -->
<section class="container section-container pt-3">
    <div class="row g-4" id="listaTutoriales">

        <!-- TUTORIAL 9 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="<?= $base ?>assets/img/condicionales.png" alt="Condicionales" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel intermedio">Tutorial 9</span>
                    <h3 class="titulo-tutorial">Condicionales</h3>
                    <p>Aprendé a tomar decisiones utilizando if y else.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.intermedio.php?id=9">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 10 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="<?= $base ?>assets/img/bucle.png" alt="Bucles" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel intermedio">Tutorial 10</span>
                    <h3 class="titulo-tutorial">Bucles</h3>
                    <p>Repetición de acciones utilizando estructuras de control.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.intermedio.php?id=10">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 11 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="<?= $base ?>assets/img/sensores.jpg" alt="Sensores" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel intermedio">Tutorial 11</span>
                    <h3 class="titulo-tutorial">Sensores</h3>
                    <p>Aprendé cómo Arduino recibe información del ambiente.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.intermedio.php?id=11">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 12 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="<?= $base ?>assets/img/lecanalogicas.png" alt="Lecturas analógicas" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel intermedio">Tutorial 12</span>
                    <h3 class="titulo-tutorial">Lecturas analógicas</h3>
                    <p>Uso de entradas analógicas para leer valores variables.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.intermedio.php?id=12">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 13 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="<?= $base ?>assets/img/bucle.png" alt="Potenciómetro" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel intermedio">Tutorial 13</span>
                    <h3 class="titulo-tutorial">Potenciómetro</h3>
                    <p>Control de valores mediante una resistencia variable.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.intermedio.php?id=13">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 14 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="<?= $base ?>assets/img/ultrasonico.jpg" alt="Sensor HC-SR04" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel intermedio">Tutorial 14</span>
                    <h3 class="titulo-tutorial">Sensor HC-SR04</h3>
                    <p>Medición de distancia mediante ultrasonido.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.intermedio.php?id=14">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 15 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="<?= $base ?>assets/img/servo.jpg" alt="Servomotores" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel intermedio">Tutorial 15</span>
                    <h3 class="titulo-tutorial">Servomotores</h3>
                    <p>Control de movimientos y posiciones con Arduino.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.intermedio.php?id=15">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 16 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="<?= $base ?>assets/img/monitorserial.png" alt="Monitor Serial" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel intermedio">Tutorial 16</span>
                    <h3 class="titulo-tutorial">Monitor Serial</h3>
                    <p>Visualización de datos enviados por Arduino.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.intermedio.php?id=16">Ver tutorial</a>
                </div>
            </article>
        </div>

    </div>

    <!-- Mensaje oculto por si no hay resultados en la búsqueda -->
    <div id="sinResultados" class="text-center text-muted d-none my-5">
      <h4>No se encontraron tutoriales que coincidan con la búsqueda.</h4>
    </div>
</section>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<!-- Script limpio para la búsqueda (ignora tildes comunes) -->
<script>
function limpiarTexto(texto) {
  return texto
    .toLowerCase()
    .replace(/á/g, 'a')
    .replace(/é/g, 'e')
    .replace(/í/g, 'i')
    .replace(/ó/g, 'o')
    .replace(/ú/g, 'u');
}

function filtrarTutoriales() {
  const inputEl = document.getElementById('inputBuscador');
  if (!inputEl) return;

  const textoBusqueda = limpiarTexto(inputEl.value.trim());
  const tarjetas = document.querySelectorAll('.tarjeta-tutorial');
  let encontrados = 0;

  tarjetas.forEach(tarjeta => {
    const tituloEl = tarjeta.querySelector('.titulo-tutorial');
    if (!tituloEl) return;
    
    const titulo = limpiarTexto(tituloEl.innerText);

    if (titulo.includes(textoBusqueda)) {
      tarjeta.classList.remove('d-none');
      encontrados++;
    } else {
      tarjeta.classList.add('d-none');
    }
  });

  const msgSinResultados = document.getElementById('sinResultados');
  if (msgSinResultados) {
    if (encontrados === 0 && textoBusqueda !== "") {
      msgSinResultados.classList.remove('d-none');
    } else {
      msgSinResultados.classList.add('d-none');
    }
  }
}
</script>

</body>
</html>