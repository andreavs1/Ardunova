<?php session_start(); $active_page='proyectos'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proyecto: Control con Potenciómetro - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
  
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container section-container">
    <div class="project-header">
        <span class="tag-nivel principiante">Principiante</span>
        <h1 class="section-title mb-2">Lectura de Potenciómetro</h1>
        <p class="section-subtitle">Aprendé a leer señales analógicas y variar la velocidad de parpadeo de un LED.</p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="project-info">
                <h2>Explicación</h2>
                <p>En este proyecto aprenderás a utilizar una entrada analógica. Al girar la perilla del potenciómetro, variamos el voltaje de entrada (de 0V a 5V). Arduino convierte esta lectura en un número y modifica el tiempo de espera del LED, haciendo que parpadee más rápido o más lento.</p>
                <h3>Materiales</h3>
                <ul>
                    <li>Arduino UNO</li>
                    <li>Potenciómetro de 10kΩ</li>
                    <li>LED</li>
                    <li>Resistencia de 220Ω</li>
                    <li>Protoboard y cables</li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="card h-100">
                <div class="card-image">
                    <img src="<?= BASE_URL ?>assets/img/potenciometro.jpg" alt="Componentes del proyecto Potenciómetro">
                </div>
            </div>
        </div>
    </div>

    <section class="code-section mt-5">
        <h2>Código</h2>
        <div class="card code-card">
            <pre><code>const int potPin = A0;  // Pin donde conectamos el potenciómetro
const int ledPin = 13;  // Pin del LED

int valorPot = 0;       // Variable para guardar la lectura

void setup() {
  pinMode(ledPin, OUTPUT);
  Serial.begin(9600);   // Inicia comunicación serie para ver los valores
}

void loop() {
  valorPot = analogRead(potPin); // Lee el valor analógico (0 a 1023)
  
  Serial.print("Valor del potenciómetro: ");
  Serial.println(valorPot);

  digitalWrite(ledPin, HIGH);
  delay(valorPot);              // El tiempo encendido depende de la perilla
  digitalWrite(ledPin, LOW);
  delay(valorPot);              // El tiempo apagado depende de la perilla
}</code></pre>
        </div>
    </section>

    <section class="steps-section mt-5">
        <h2 class="mb-4">Paso a paso</h2>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Conexiones</h4>
                    <p>Conectá las patas extremas del potenciómetro a 5V y GND, y la pata central al pin A0. El LED va al pin 13 con su resistencia.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Software</h4>
                    <p>Abrí Arduino IDE, copiá el código y abrí el Monitor Serie (a 9600 baudios) para visualizar las lecturas en tiempo real.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Prueba</h4>
                    <p>Cargá el programa y girá la perilla del potenciómetro para ver cómo cambia el intervalo de parpadeo del LED.</p>
                </div>
            </div>
        </div>

        <div class="result-card">
            <h4>Resultado esperado</h4>
            <p class="mb-0">Al girar la perilla en un sentido el parpadeo será muy rápido, y al girarla hacia el otro extremo el LED parpadeará más despacio.</p>
        </div>

        <div class="text-center button-container">
            <a href="<?= BASE_URL ?>proyecto/proyectos.php" class="btn btn-outline-cyan">← Volver a Proyectos</a>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>