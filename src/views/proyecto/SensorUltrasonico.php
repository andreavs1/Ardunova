<?php session_start(); $active_page = 'proyectos'; ?>
<!DOCTYPE html>
<html lang="es"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Medición de distancia mediante un sensor ultrasónico conectado a Arduino.">
    <title>Sensor Ultrasónico de Distancia - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="container section-container">
    <div class="contenedor">
        <span class="tag-nivel intermedio">Intermedio</span>
        <h1 class="section-title">🔊 Sensor Ultrasónico de Distancia</h1>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="project-info">
                    <h2>Sobre el proyecto</h2>
                    <p>Medición precisa de distancias a objetos en centímetros utilizando ondas de sonido de alta frecuencia mediante el módulo HC-SR04.</p>
                    <h3>Objetivo</h3>
                    <p>Comprender cómo medir tiempos de respuesta (pulsos ecos) y calcular la velocidad del sonido en el aire.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-image text-center p-3">
                        <img src="<?= BASE_URL ?>assets/img/ultrasonico.jpg" alt="Sensor Ultrasónico" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-5">
            <h2 class="mb-4">🧰 Componentes necesarios</h2>
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item">1x Placa Arduino UNO</li>
                <li class="list-group-item">1x Sensor Ultrasónico HC-SR04</li>
                <li class="list-group-item">Protoboard y cables Jumper</li>
            </ul>

            <h2 class="mb-4">🔌 Esquema de conexión</h2>
            <div class="card my-3">
                <div class="card-body">
                    <ul>
                        <li><strong>VCC:</strong> Pin 5V de Arduino.</li>
                        <li><strong>Trig:</strong> Pin Digital 9 de Arduino.</li>
                        <li><strong>Echo:</strong> Pin Digital 8 de Arduino.</li>
                        <li><strong>GND:</strong> Pin GND de Arduino.</li>
                    </ul>
                </div>
            </div>

            <h2 class="mb-4">Pasos básicos</h2>
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="setup-step p-4 border rounded shadow-sm bg-white h-100">
                        <h4>1. Preparar</h4>
                        <p>Reuní los componentes y verificá las conexiones del sensor a los pines de Arduino.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="setup-step p-4 border rounded shadow-sm bg-white h-100">
                        <h4>2. Programar</h4>
                        <p>Cargá el sketch correspondiente y abrí el Monitor Serie a 9600 baudios.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="setup-step p-4 border rounded shadow-sm bg-white h-100">
                        <h4>3. Probar</h4>
                        <p>Acercá obstáculos frente al módulo para visualizar la distancia en tiempo real.</p>
                    </div>
                </div>
            </div>

            <h2 class="mt-5 mb-4">💻 Código Fuente</h2>
            <pre class="codigo"><code>const int pinTrig = 9;
const int pinEcho = 8;

void setup() {
    pinMode(pinTrig, OUTPUT);
    pinMode(pinEcho, INPUT);
    Serial.begin(9600);
}

void loop() {
    digitalWrite(pinTrig, LOW);
    delayMicroseconds(2);
    digitalWrite(pinTrig, HIGH);
    delayMicroseconds(10);
    digitalWrite(pinTrig, LOW);

    long duracion = pulseIn(pinEcho, HIGH);
    int distancia = duracion * 0.034 / 2;

    Serial.print("Distancia: ");
    Serial.print(distancia);
    Serial.println(" cm");
    delay(200);
}</code></pre>
        </section>

        <div class="text-center button-container my-4">
           <a href="<?= BASE_URL ?>proyecto/proyectos.php" class="btn btn-outline-cyan">← Volver a Proyectos</a> 
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>

  