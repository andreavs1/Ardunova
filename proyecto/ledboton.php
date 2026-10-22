<?php session_start(); $active_page='proyectos'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proyecto: Control de LED con Pulsador - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
  
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container section-container">
    <div class="project-header">
        <span class="tag-nivel principiante">Principiante</span>
        <h1 class="section-title mb-2">Control de LED con Pulsador</h1>
        <p class="section-subtitle">Aprendé a leer entradas digitales para encender un LED al presionar un botón.</p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="project-info">
                <h2>Explicación</h2>
                <p>Este proyecto enseña cómo utilizar una entrada digital en Arduino. Al presionar el pulsador (botón), cerramos el circuito y enviamos un estado alto (HIGH) a un pin digital, activando la salida donde está conectado el LED.</p>
                <h3>Materiales</h3>
                <ul>
                    <li>Arduino UNO</li>
                    <li>LED</li>
                    <li>Pulsador (Push Button)</li>
                    <li>Resistencia de 220Ω (para el LED)</li>
                    <li>Resistencia de 10kΩ (Pull-down para el botón)</li>
                    <li>Protoboard y cables</li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="card h-100">
                <div class="card-image">
                    <img src="<?= BASE_URL ?>assets/img/ledBoton.jpg" alt="Componentes del proyecto LED con Pulsador">
                </div>
            </div>
        </div>
    </div>

    <section class="code-section mt-5">
        <h2>Código</h2>
        <div class="card code-card">
            <pre><code>const int botonPin = 2; // Pin donde conectamos el pulsador
const int ledPin = 13;   // Pin donde conectamos el LED

int estadoBoton = 0;     // Variable para almacenar el estado del pulsador

void setup() {
  pinMode(ledPin, OUTPUT);
  pinMode(botonPin, INPUT);
}

void loop() {
  // Lee si el pulsador está presionado (HIGH) o no (LOW)
  estadoBoton = digitalRead(botonPin);

  if (estadoBoton == HIGH) {
    digitalWrite(ledPin, HIGH); // Enciende el LED
  } else {
    digitalWrite(ledPin, LOW);  // Apaga el LED
  }
}</code></pre>
        </div>
    </section>

    <section class="steps-section mt-5">
        <h2 class="mb-4">Paso a paso</h2>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Conexiones</h4>
                    <p>Conectá un terminal del pulsador a 5V y el otro al pin 2 junto con una resistencia de 10kΩ a GND. Conectá el LED al pin 13 con su resistencia de 220Ω.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Software</h4>
                    <p>Abrí Arduino IDE, copiá el código presentado arriba y seleccioná la placa Arduino UNO en la configuración.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Prueba</h4>
                    <p>Cargá el programa en tu placa. Mantené presionado el pulsador para encender el LED y soltalo para apagarlo.</p>
                </div>
            </div>
        </div>

        <div class="result-card">
            <h4>Resultado esperado</h4>
            <p class="mb-0">El LED permanecerá apagado y se encenderá únicamente mientras mantengas presionado el botón.</p>
        </div>

        <div class="text-center button-container">
            <a href="<?= BASE_URL ?>proyecto/proyectos.php" class="btn btn-outline-cyan">← Volver a Proyectos</a>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>