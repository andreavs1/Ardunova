<?php
session_start();
$active_page = 'tutoriales';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nivel Avanzado - ARDUNOVA</title>
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
      <span class="section-kicker">Ruta de aprendizaje · 03</span>
      <h1 class="section-title mb-2">Nivel avanzado</h1>
      <p class="mb-0">Profundizá en comunicaciones, librerías e integraciones complejas.</p>
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

        <!-- TUTORIAL 17 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="../assets/img/librerias.png" alt="Librerías" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel avanzado">Tutorial 17</span>
                    <h3 class="titulo-tutorial">Librerías</h3>
                    <p>Uso de librerías para ampliar las funciones de Arduino.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.avanzado.php?id=17">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 18 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="../assets/img/lcd.jpg" alt="Pantallas LCD" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel avanzado">Tutorial 18</span>
                    <h3 class="titulo-tutorial">Pantallas LCD</h3>
                    <p>Mostrar información utilizando pantallas conectadas a Arduino.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.avanzado.php?id=18">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 19 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="../assets/img/bluetooth.jpg" alt="Comunicación Bluetooth" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel avanzado">Tutorial 19</span>
                    <h3 class="titulo-tutorial">Comunicación Bluetooth</h3>
                    <p>Control y envío de información de manera inalámbrica.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.avanzado.php?id=19">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 20 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="../assets/img/wifi.jpg" alt="Comunicación Wi-Fi" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel avanzado">Tutorial 20</span>
                    <h3 class="titulo-tutorial">Comunicación Wi-Fi</h3>
                    <p>Conexión de Arduino a redes inalámbricas e IoT.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.avanzado.php?id=20">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 21 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="../assets/img/i2c.png" alt="Comunicación I2C" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel avanzado">Tutorial 21</span>
                    <h3 class="titulo-tutorial">Comunicación I2C</h3>
                    <p>Conexión de dispositivos usando el protocolo I2C.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.avanzado.php?id=21">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 22 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="../assets/img/comunicacion.png" alt="Comunicación SPI" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel avanzado">Tutorial 22</span>
                    <h3 class="titulo-tutorial">Comunicación SPI</h3>
                    <p>Intercambio de información a alta velocidad con perisféricos.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.avanzado.php?id=22">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 23 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="../assets/img/componentes.png" alt="Varios componentes" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel avanzado">Tutorial 23</span>
                    <h3 class="titulo-tutorial">Varios componentes</h3>
                    <p>Uso e integración de múltiples elementos en un proyecto.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.avanzado.php?id=23">Ver tutorial</a>
                </div>
            </article>
        </div>

        <!-- TUTORIAL 24 -->
        <div class="col-12 col-sm-6 col-lg-4 tarjeta-tutorial">
            <article class="card">
                <div class="card-image">
                    <img src="../assets/img/errores.png" alt="Solución de errores" class="card-img-top">
                </div>
                <div class="card-body">
                    <span class="tag-nivel avanzado">Tutorial 24</span>
                    <h3 class="titulo-tutorial">Solución de errores</h3>
                    <p>Métodos para encontrar y corregir problemas en proyectos.</p>
                    <a class="btn btn-gradient mt-1 w-100" href="tutorial.avanzado.php?id=24">Ver tutorial</a>
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