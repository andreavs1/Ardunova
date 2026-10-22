<?php
session_start();
$active_page = 'tutoriales';
?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Nivel Principiante - ARDUNOVA</title>
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
      <span class="section-kicker">Ruta de aprendizaje · 01</span>
      <h1 class="section-title mb-2">Nivel principiante</h1>
      <p class="mb-0">Empezá por los fundamentos y avanzá con tus primeros proyectos.</p>
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

<!-- TUTORIAL 1 -->
<div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
<article class="card">
<div class="card-image">
    <img src="../assets/img/arduinoquees.jpg" alt="¿Qué es Arduino?" class="card-img-top">
</div>
<div class="card-body">
<span class="tag-nivel principiante">
Tutorial 1
</span>
<h3 class="titulo-tutorial">
¿Qué es Arduino?
</h3>
<p>
Conocé qué es Arduino y para qué sirve.
</p>
<a class="btn btn-gradient mt-1 w-100" href="tutorial.principiante.php?id=1">
Ver tutorial
</a>
</div>
</article>
</div>

<!-- TUTORIAL 2 -->
<div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
<article class="card">
<div class="card-image">
    <img src="../assets/img/partes-arduino.jpg" alt="Placa Arduino" class="card-img-top">
</div>
<div class="card-body">
<span class="tag-nivel principiante">
Tutorial 2
</span>
<h3 class="titulo-tutorial">
Placa Arduino
</h3>
<p>
Partes principales de la placa y conexiones.
</p>
<a class="btn btn-gradient mt-1 w-100" href="tutorial.principiante.php?id=2">
Ver tutorial
</a>
</div>
</article>
</div>

<!-- TUTORIAL 3 -->
<div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
<article class="card">
<div class="card-image">
    <img src="../assets/img/arduinoide.png" alt="Arduino IDE" class="card-img-top">
</div>
<div class="card-body">
<span class="tag-nivel principiante">
Tutorial 3
</span>
<h3 class="titulo-tutorial">
Arduino IDE
</h3>
<p>
Programa utilizado para escribir códigos.
</p>
<a class="btn btn-gradient mt-1 w-100" href="tutorial.principiante.php?id=3">
Ver tutorial
</a>
</div>
</article>
</div>

<!-- TUTORIAL 4 -->
<div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
<article class="card">
<div class="card-image">
    <img src="../assets/img/setup.png" alt="Estructura del programa" class="card-img-top">
</div>
<div class="card-body">
<span class="tag-nivel principiante">
Tutorial 4
</span>
<h3 class="titulo-tutorial">
Estructura del programa
</h3>
<p>
Aprendé cómo funcionan setup() y loop().
</p>
<a class="btn btn-gradient mt-1 w-100" href="tutorial.principiante.php?id=4">
Ver tutorial
</a>
</div>
</article>
</div>

<!-- TUTORIAL 5 -->
<div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
<article class="card">
<div class="card-image">
    <img src="../assets/img/variables.png" alt="Variables" class="card-img-top">
</div>
<div class="card-body">
<span class="tag-nivel principiante">
Tutorial 5
</span>
<h3 class="titulo-tutorial">
Variables
</h3>
<p>
Uso de datos dentro de Arduino.
</p>
<a class="btn btn-gradient mt-1 w-100" href="tutorial.principiante.php?id=5">
Ver tutorial
</a>
</div>
</article>
</div>

<!-- TUTORIAL 6 -->
<div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
<article class="card">
<div class="card-image">
    <img src="../assets/img/entradas-analogicas.jpg" alt="Entradas y salidas" class="card-img-top">
</div>
<div class="card-body">
<span class="tag-nivel principiante">
Tutorial 6
</span>
<h3 class="titulo-tutorial">
Entradas y salidas
</h3>
<p>
Control de componentes mediante Arduino.
</p>
<a class="btn btn-gradient mt-1 w-100" href="tutorial.principiante.php?id=6">
Ver tutorial
</a>
</div>
</article>
</div>

<!-- TUTORIAL 7 -->
<div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
<article class="card">
<div class="card-image">
    <img src="../assets/img/encenderled.png" alt="Encender LED" class="card-img-top">
</div>
<div class="card-body">
<span class="tag-nivel principiante">
Tutorial 7
</span>
<h3 class="titulo-tutorial">
Encender LED
</h3>
<p>
Primer proyecto práctico con Arduino.
</p>
<a class="btn btn-gradient mt-1 w-100" href="tutorial.principiante.php?id=7">
Ver tutorial
</a>
</div>
</article>
</div>

<!-- TUTORIAL 8 -->
<div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
<article class="card">
<div class="card-image">
    <img src="../assets/img/pulsador.jpg" alt="Pulsadores" class="card-img-top">
</div>
<div class="card-body">
<span class="tag-nivel principiante">
Tutorial 8
</span>
<h3 class="titulo-tutorial">
Pulsadores
</h3>
<p>
Uso de botones para controlar Arduino.
</p>
<a class="btn btn-gradient mt-1 w-100" href="tutorial.principiante.php?id=8">
Ver tutorial
</a>
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