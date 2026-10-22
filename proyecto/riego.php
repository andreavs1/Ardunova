<?php session_start(); $active_page='proyectos'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proyecto: Sistema de Riego Automático - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
  
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container section-container">
    <div class="project-header">
        <span class="tag-nivel intermedio">Intermedio</span>
        <h1 class="section-title mb-2">Sistema de Riego Automático</h1>
        <p class="section-subtitle">Mantiene la humedad de tus plantas monitoreando el suelo en tiempo real.</p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="project-info">
                <h2>Explicación</h2>
                <p>Este proyecto utiliza un sensor de humedad de suelo para detectar si la tierra está seca. Cuando los niveles bajan de cierto umbral, el Arduino activa un módulo relé que enciende una bomba de agua hasta que la humedad vuelve a ser óptima.</p>
                <h3>Materiales</h3>
                <ul>
                    <li>Arduino UNO</li>
                    <li>Sensor de humedad de suelo (YL-69 o FC-28)</li>
                    <li>Módulo Relé de 1 canal (5V)</li>
                    <li>Mini bomba de agua sumergible (5V - 12V)</li>
                    <li>Fuente de alimentación externa o batería</li>
                    <li>Protoboard y cables m-m / m-h</li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="card h-100">
                <div class="card-image">
                    <img src="<?= BASE_URL ?>assets/img/sistemaDeRiego.jpg" alt="Componentes del proyecto Riego Automático">
                </div>
            </div>
        </div>
    </div>

    <section class="code-section mt-5">
        <h2>Código</h2>
        <div class="card code-card">
            <pre><code>const int sensorPin = A0;
const int relePin = 7;
int umbralHumedad = 500; // Ajustar según el tipo de suelo

void setup() {
  pinMode(relePin, OUTPUT);
  digitalWrite(relePin, HIGH); // Mantiene la bomba apagada al inicio
  Serial.begin(9600);
}

void loop() {
  int valorSensor = analogRead(sensorPin);
  Serial.print("Valor de humedad: ");
  Serial.println(valorSensor);

  if (valorSensor > umbralHumedad) {
    // Tierra seca: Activa el relé (bomba encendida)
    digitalWrite(relePin, LOW); 
  } else {
    // Tierra húmeda: Desactiva el relé (bomba apagada)
    digitalWrite(relePin, HIGH); 
  }

  delay(2000);
}</code></pre>
        </div>
    </section>

    <section class="steps-section mt-5">
        <h2 class="mb-4">Paso a paso</h2>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Conexiones</h4>
                    <p>Conectá la salida analógica del sensor al pin A0 y el pin de señal (IN) del módulo relé al pin digital 7 del Arduino.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Software</h4>
                    <p>Copiá el código en el IDE de Arduino. Ajustá la variable <code>umbralHumedad</code> según la respuesta de tu sensor.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Carga y prueba</h4>
                    <p>Cargá el programa, colocá las puntas del sensor en tierra seca y observá cómo se activa la bomba a través del relé.</p>
                </div>
            </div>
        </div>

        <div class="result-card">
            <h4>Resultado esperado</h4>
            <p class="mb-0">El sistema medirá la humedad continuamente y activará el riego solo cuando la tierra requiera agua.</p>
        </div>

        <div class="text-center button-container">
            <a href="<?= BASE_URL ?>proyecto/proyectos.php" class="btn btn-outline-cyan">← Volver a Proyectos</a>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>