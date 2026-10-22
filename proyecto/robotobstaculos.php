<?php session_start(); $active_page='proyectos'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proyecto: Robot Esquivador de Obstáculos - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
  
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container section-container">
    <div class="project-header">
        <span class="tag-nivel intermedio">Intermedio</span>
        <h1 class="section-title mb-2">Robot Esquivador de Obstáculos</h1>
        <p class="section-subtitle">Construí un vehículo autónomo capaz de navegar y evitar objetos en su camino.</p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="project-info">
                <h2>Explicación</h2>
                <p>Este proyecto integra robótica móvil y sensores de ultrasonido. El robot avanza de forma continua midiendo la distancia hacia los objetos al frente. Si detecta un obstáculo a menos de una distancia segura, se detiene, retrocede y gira para cambiar de dirección automáticamente.</p>
                <h3>Materiales</h3>
                <ul>
                    <li>Arduino UNO</li>
                    <li>Chasis de robot de 2 ruedas con motores DC</li>
                    <li>Módulo controlador de motores L298N</li>
                    <li>Sensor ultrasónico HC-SR04</li>
                    <li>Portapilas o batería externa (7.4V - 12V)</li>
                    <li>Protoboard y cables de conexión</li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="card h-100">
                <div class="card-image">
                    <img src="<?= BASE_URL ?>assets/img/robotobstaculos.jpg" alt="Componentes del proyecto Robot Esquivador de Obstáculos">
                </div>
            </div>
        </div>
    </div>

    <section class="code-section mt-5">
        <h2>Código</h2>
        <div class="card code-card">
            <pre><code>// Pines del Sensor Ultrasónico
const int trigPin = 9;
const int echoPin = 8;

// Pines del Controlador de Motores L298N
const int motorIzquierda1 = 2;
const int motorIzquierda2 = 3;
const int motorDerecha1 = 4;
const int motorDerecha2 = 5;

const int umbralDistancia = 20; // Distancia límite en centímetros

void setup() {
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);

  pinMode(motorIzquierda1, OUTPUT);
  pinMode(motorIzquierda2, OUTPUT);
  pinMode(motorDerecha1, OUTPUT);
  pinMode(motorDerecha2, OUTPUT);
}

void loop() {
  long duracion;
  int distancia;

  // Medición de distancia con HC-SR04
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);

  duracion = pulseIn(echoPin, HIGH);
  distancia = duracion * 0.034 / 2;

  if (distancia > 0 && distancia < umbralDistancia) {
    // Si hay un obstáculo cerca: Detener, retroceder y girar
    detener();
    delay(200);
    retroceder();
    delay(400);
    girarIzquierda();
    delay(500);
  } else {
    // Camino libre: Avanzar
    avanzar();
  }
}

// Funciones de control de movimiento
void avanzar() {
  digitalWrite(motorIzquierda1, HIGH);
  digitalWrite(motorIzquierda2, LOW);
  digitalWrite(motorDerecha1, HIGH);
  digitalWrite(motorDerecha2, LOW);
}

void retroceder() {
  digitalWrite(motorIzquierda1, LOW);
  digitalWrite(motorIzquierda2, HIGH);
  digitalWrite(motorDerecha1, LOW);
  digitalWrite(motorDerecha2, HIGH);
}

void girarIzquierda() {
  digitalWrite(motorIzquierda1, LOW);
  digitalWrite(motorIzquierda2, HIGH);
  digitalWrite(motorDerecha1, HIGH);
  digitalWrite(motorDerecha2, LOW);
}

void detener() {
  digitalWrite(motorIzquierda1, LOW);
  digitalWrite(motorIzquierda2, LOW);
  digitalWrite(motorDerecha1, LOW);
  digitalWrite(motorDerecha2, LOW);
}</code></pre>
        </div>
    </section>

    <section class="steps-section mt-5">
        <h2 class="mb-4">Paso a paso</h2>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Conexiones</h4>
                    <p>Conectá los motores al módulo L298N y las salidas de control del módulo a los pines digitales 2, 3, 4 y 5 del Arduino. El HC-SR04 va conectado a los pines 8 (Echo) y 9 (Trig).</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Software</h4>
                    <p>Abrí Arduino IDE, copiá el programa e instalá la energía de los motores mediante una fuente externa conectada al driver L298N.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="setup-step p-4">
                    <h4>Prueba</h4>
                    <p>Colocá el robot en el suelo y colocá obstáculos en su trayectoria para verificar cómo se detiene y redirige su camino.</p>
                </div>
            </div>
        </div>

        <div class="result-card">
            <h4>Resultado esperado</h4>
            <p class="mb-0">El robot avanzará en línea recta y girará automáticamente hacia una nueva dirección cada vez que encuentre un obstáculo a menos de 20 cm.</p>
        </div>

        <div class="text-center button-container">
           <a href="<?= BASE_URL ?>proyecto/proyectos.php" class="btn btn-outline-cyan">← Volver a Proyectos</a>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>