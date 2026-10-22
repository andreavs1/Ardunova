<?php
session_start();
$active_page = 'proyectos';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="ARDUNOVA - Aprendizaje práctico de Arduino, electrónica y robótica.">

  <title>Proyectos Prácticos - ARDUNOVA</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/style.css?v=20261020-5">
</head>

<body>

<?php include 'includes/header.php'; ?>

<main class="container section-container">

  <div class="page-heading">
    <span class="section-kicker">Catálogo de proyectos</span>
    <h1 class="section-title">Proyectos prácticos</h1>
    <p>Elegí un proyecto y aprendé construyéndolo paso a paso.</p>
  </div>

  <div class="filtros">

    <label for="filtro-nivel">Filtrar por nivel:</label>

    <select id="filtro-nivel" class="filtro-select">
      <option value="todos">Todos</option>
      <option value="principiante">Principiante</option>
      <option value="intermedio">Intermedio</option>
      <option value="avanzado">Avanzado</option>
    </select>

  </div>


  <div class="row g-4">

    <!-- PROYECTO 1 -->
    <div class="col-12 col-sm-6 col-lg-4 proyecto" data-nivel="principiante">

      <article class="card">

        <div class="card-image">
          <img alt="LED parpadeante con Arduino" src="assets/img/led.jpg">
        </div>

        <div class="card-body">

          <span class="tag-nivel principiante">
            Principiante
          </span>

          <h3>
            Parpadeo de LED (Blink)
          </h3>

          <p>
            El clásico "Hola Mundo" del hardware. Aprendé el control básico del ciclo de procesamiento interno de salidas digitales.
          </p>

          <a class="btn btn-gradient mt-1 w-100" href="proyecto/ledblink.php">
            Ver Proyecto
          </a>

        </div>

      </article>

    </div>


    <!-- PROYECTO 2 -->
    <div class="col-12 col-sm-6 col-lg-4 proyecto" data-nivel="intermedio">

      <article class="card">

        <div class="card-image">
          <img alt="Pantalla LCD Dinámica" src="assets/img/lcd-dinamica.jpg">
        </div>

        <div class="card-body">

          <span class="tag-nivel intermedio">
            Intermedio
          </span>

          <h3>
            Pantalla LCD Dinámica
          </h3>

          <p>
            Desplegá textos fijos y dinámicos con desplazamiento lateral programado controlando el contraste del dispositivo.
          </p>

          <a class="btn btn-gradient mt-1 w-100" href="proyecto/lcddinamica.php">
            Ver Proyecto
          </a>

        </div>

      </article>

    </div>


    <!-- PROYECTO 3 -->
    <div class="col-12 col-sm-6 col-lg-4 proyecto" data-nivel="principiante">

      <article class="card">

        <div class="card-image">
          <img alt="Semáforo Básico Arduino" src="assets/img/semaforo-arduino.png">
        </div>

        <div class="card-body">

          <span class="tag-nivel principiante">
            Principiante
          </span>

          <h3>
            Semáforo Inteligente
          </h3>

          <p>
            Diseño funcional de un cruce peatonal sincronizado empleando temporizaciones algorítmicas secuenciales.
          </p>

          <a class="btn btn-gradient mt-1 w-100" href="proyecto/SemaforoA.php">
            Ver Proyecto
          </a>

        </div>

      </article>

    </div>


    <!-- PROYECTO 4 -->
    <div class="col-12 col-sm-6 col-lg-4 proyecto" data-nivel="intermedio">

      <article class="card">

        <div class="card-image">
          <img alt="Sensor Ultrasónico de Distancia" src="assets/img/ultrasonico.jpg">
        </div>

        <div class="card-body">

          <span class="tag-nivel intermedio">
            Intermedio
          </span>

          <h3>
            Sensor Ultrasónico de Distancia
          </h3>

          <p>
            Medición precisa de proximidad calculando el tiempo de retorno de ondas de sonido de alta frecuencia.
          </p>

          <a class="btn btn-gradient mt-1 w-100" href="proyecto/SensorUltrasonico.php">
            Ver Proyecto
          </a>

        </div>

      </article>

    </div>


    <!-- PROYECTO 5 -->
    <div class="col-12 col-sm-6 col-lg-4 proyecto" data-nivel="intermedio">

      <article class="card">

        <div class="card-image">
          <img alt="Domótica" src="assets/img/domotica.jpg">
        </div>

        <div class="card-body">

          <span class="tag-nivel intermedio">
            Intermedio
          </span>

          <h3>
            Domótica Básica
          </h3>

          <p>
            Automatizá el encendido de luces de tu hogar utilizando relevadores eléctricos seguros y sensores de presencia.
          </p>

          <a class="btn btn-gradient mt-1 w-100" href="proyecto/domotica.php">
            Ver Proyecto
          </a>

        </div>

      </article>

    </div>


    <!-- PROYECTO 6 -->
    <div class="col-12 col-sm-6 col-lg-4 proyecto" data-nivel="avanzado">

      <article class="card">

        <div class="card-image">
          <img alt="Auto Seguidor de Línea" src="assets/img/robot-seguidor-linea.png">
        </div>

        <div class="card-body">

          <span class="tag-nivel avanzado">
            Avanzado
          </span>

          <h3>
            Auto Seguidor de Línea
          </h3>

          <p>
            Integración total de motores de corriente continua, puentes H de potencia y algoritmos lógicos PID.
          </p>

          <a class="btn btn-gradient mt-1 w-100" href="proyecto/seguidorlinea.php">
            Ver Proyecto
          </a>

        </div>

      </article>

    </div>


    <!-- PROYECTO 7 -->
    <div class="col-12 col-sm-6 col-lg-4 proyecto" data-nivel="principiante">

      <article class="card">

        <div class="card-image">
          <img alt="LED con botón" src="assets/img/ledBoton.jpg">
        </div>

        <div class="card-body">

          <span class="tag-nivel principiante">
            Principiante
          </span>

          <h3>
            LED con botón
          </h3>

          <p>
            Aprendé a controlar un LED utilizando un botón pulsador y las entradas y salidas digitales de Arduino.
          </p>

          <a class="btn btn-gradient mt-1 w-100" href="proyecto/ledboton.php">
            Ver Proyecto
          </a>

        </div>

      </article>

    </div>


    <!-- PROYECTO 8 -->
    <div class="col-12 col-sm-6 col-lg-4 proyecto" data-nivel="principiante">

      <article class="card">

        <div class="card-image">
          <img alt="LED con potenciómetro" src="assets/img/potenciometro.jpg">
        </div>

        <div class="card-body">

          <span class="tag-nivel principiante">
            Principiante
          </span>

          <h3>
            LED con potenciómetro
          </h3>

          <p>
            Aprendé a controlar la intensidad de un LED utilizando un potenciómetro y una salida PWM de Arduino.
          </p>

          <a class="btn btn-gradient mt-1 w-100" href="proyecto/potenciometro.php">
            Ver Proyecto
          </a>

        </div>

      </article>

    </div>


    <!-- PROYECTO 9 -->
    <div class="col-12 col-sm-6 col-lg-4 proyecto" data-nivel="intermedio">

      <article class="card">

        <div class="card-image">
          <img alt="Sensor de luz LDR" src="assets/img/sensorDeLuz.jpg">
        </div>

        <div class="card-body">

          <span class="tag-nivel intermedio">
            Intermedio
          </span>

          <h3>
            Sensor de luz LDR
          </h3>

          <p>
            Utilizá un sensor LDR para detectar la cantidad de luz del ambiente y controlar diferentes LEDs mediante Arduino.
          </p>

          <a class="btn btn-gradient mt-1 w-100" href="proyecto/sensorluZ.php">
            Ver Proyecto
          </a>

        </div>

      </article>

    </div>


    <!-- PROYECTO 10 -->
    <div class="col-12 col-sm-6 col-lg-4 proyecto" data-nivel="avanzado">

      <article class="card">

        <div class="card-image">
          <img alt="Sistema de riego automático" src="assets/img/sistemaDeRiego.jpg">
        </div>

        <div class="card-body">

          <span class="tag-nivel avanzado">
            Avanzado
          </span>

          <h3>
            Sistema de riego automático
          </h3>

          <p>
            Automatizá el riego de una planta utilizando sensores y Arduino para detectar cuándo es necesario activar el sistema.
          </p>

          <a class="btn btn-gradient mt-1 w-100" href="proyecto/riego.php">
            Ver Proyecto
          </a>

        </div>

      </article>

    </div>


    <!-- PROYECTO 11 -->
    <div class="col-12 col-sm-6 col-lg-4 proyecto" data-nivel="avanzado">

      <article class="card">

        <div class="card-image">
          <img alt="Robot evita obstáculos" src="assets/img/robotobstaculos.jpg">
        </div>

        <div class="card-body">

          <span class="tag-nivel avanzado">
            Avanzado
          </span>

          <h3>
            Robot evita obstáculos
          </h3>

          <p>
            Construí un robot capaz de detectar obstáculos mediante sensores y modificar su recorrido automáticamente.
          </p>

          <a class="btn btn-gradient mt-1 w-100" href="proyecto/robotobstaculos.php">
            Ver Proyecto
          </a>

        </div>

      </article>

    </div>


    <!-- PROYECTO 12 -->
    <div class="col-12 col-sm-6 col-lg-4 proyecto" data-nivel="intermedio">

      <article class="card">

        <div class="card-image">
          <img alt="Servomotor con Arduino" src="assets/img/servoMotor.jpg">
        </div>

        <div class="card-body">

          <span class="tag-nivel intermedio">
            Intermedio
          </span>

          <h3>
            Servomotor con Arduino
          </h3>

          <p>
            Aprendé a controlar la posición de un servomotor utilizando Arduino y programación.
          </p>

          <a class="btn btn-gradient mt-1 w-100" href="proyecto/servoMotor.php">
            Ver Proyecto
          </a>

        </div>

      </article>

    </div>

  </div>

</main>


<?php include 'includes/chatbot.php'; ?>
<?php include 'includes/footer.php'; ?>


<script>
  const selectFiltro = document.getElementById("filtro-nivel");
  const proyectos = document.querySelectorAll(".proyecto");

  selectFiltro.addEventListener("change", function() {

    let nivel = this.value;
    proyectos.forEach(function(proyecto) {
      if (nivel === "todos" || proyecto.dataset.nivel === nivel) {
        proyecto.style.display = "";
      } else {
        proyecto.style.display = "none";
      }
    });
  });
</script>

</body>
</html>
