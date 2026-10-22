<?php session_start(); $active_page='proyectos'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proyecto: Sensor de Luz - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
  
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container section-container">
    <div class="project-header">
        <span class="tag-nivel principiante">Principiante</span>
        <h1 class="section-title mb-2">Sensor de Luz (LDR)</h1>
        <p class="section-subtitle">Crea una luz nocturna automática que se enciende en la oscuridad.</p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="project-info">
                <h2>Explicación</h2>
                <p>Este proyecto utiliza un sensor LDR (Resistencia Dependiente de la Luz) para detectar la cantidad de iluminación en el ambiente. Cuando la luz baja de cierto límite, el Arduino enciende automáticamente un LED, simulando el funcionamiento de una farola o luz nocturna automática.</p>
                <h3>Materiales</h3>
                <ul>
                    <li>Arduino UNO</li>
                    <li>Sensor de luz (LDR)</li>
                    <li>LED</li>
                    <li>Resistencia de 10kΩ</li>
                    <li>Resistencia de 220Ω</li>
                    <li>Protoboard y cables</li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="card h-100">
                <div class="card-image">
                    <img src="../assets/img/sensorDeLuz.jpg" alt="Componentes del proyecto Sensor de Luz">
                </div>
            </div>
        </div>
    </div>

    <section class="code-section mt-5">
        <h2>Código</h2>
        <div class="card code-card">
            <pre><code>const int ldrPin = A0;   // Pin donde conectamos el sensor de luz
const int ledPin = 13;   // Pin donde conectamos el LED

int umbralLuz = 500;     // Nivel de oscuridad para encender el LED

void setup() {
  pinMode(ledPin, OUTPUT);
  Serial.begin(9600);    // Permite monitorizar los valores en tiempo real
}

void loop() {
  int valorLuz = analogRead(ldrPin);
  
  Serial.print("Nivel de luz medido: ");
  Serial.println(valorLuz);

  if (valorLuz < umbralLuz) {
    digitalWrite(ledPin, HIGH); // Hay oscuridad: Enciende el LED
  } else {
    digitalWrite(ledPin, LOW);  // Hay luz suficiente: Apaga el LED
  }

  delay(500);
}</code></pre>
        </div>
    </section>

    <section class="steps-section mt-5">
        <h2 class="mb-4">Paso a paso</h2>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Conexiones</h4>
                    <p>Conectá un terminal del LDR a 5V y el otro a A0 junto a una resistencia de 10kΩ conectada a GND. Conectá el LED al pin 13 con su resistencia de 220Ω.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Software</h4>
                    <p>Copiá el código al IDE de Arduino. Podés abrir el Monitor Serie para observar cómo cambian los valores según la luz del entorno.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Prueba</h4>
                    <p>Cargá el programa y tapá el sensor con la mano para comprobar cómo responde el LED en condiciones de oscuridad.</p>
                </div>
            </div>
        </div>

        <div class="result-card">
            <h4>Resultado esperado</h4>
            <p class="mb-0">El LED permanecerá apagado con luz ambiente y se encenderá automáticamente cuando cubras el sensor.</p>
        </div>

        <div class="text-center button-container">
           <a href="<?= BASE_URL ?>proyecto/proyectos.php" class="btn btn-outline-cyan">← Volver a Proyectos</a>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>