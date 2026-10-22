<?php session_start(); $active_page = 'proyectos'; ?>
<!DOCTYPE html>
<html lang="es"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Robot móvil autónomo que utiliza sensores para seguir una línea."><title>Auto Seguidor de Línea - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>


<main class="container section-container">
    <div class="contenedor">
        <span class="tag-nivel avanzado">Avanzado</span>
        <h1 class="section-title">🚗 Auto Seguidor de Línea</h1>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="project-info">
                    <h2>Sobre el proyecto</h2>
                    <p>Robot móvil autónomo con tracción 2WD guiado por sensores infrarrojos que corrigen el rumbo según la trayectoria marcada en el suelo.</p>
                    <h3>Objetivo</h3>
                    <p>Control de puentes H (L298N) para motores DC y lecturas digitales comparativas con sensores infrarrojos TCRT5000.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-image text-center p-3">
                        <img src="<?= BASE_URL ?>assets/img/robot-seguidor-linea.png" alt="Auto Seguidor de Línea" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-5">
            <h2 class="mb-4">🧰 Componentes necesarios</h2>
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item">1x Placa Arduino UNO</li>
                <li class="list-group-item">1x Chasis 2WD con 2 Motores DC y Rueda Loca</li>
                <li class="list-group-item">1x Driver Puente H L298N</li>
                <li class="list-group-item">2x Módulos Infrarrojos TCRT5000</li>
                <li class="list-group-item">1x Portapilas / Batería externa (7.4V - 9V)</li>
            </ul>

            <h2 class="mb-4">🔌 Esquema de conexión</h2>
            <div class="card my-3">
                <div class="card-body">
                    <ul>
                        <li><strong>Sensores IR:</strong> Izquierdo al Pin 2, Derecho al Pin 3.</li>
                        <li><strong>Driver L298N:</strong> IN1 (Pin 4), IN2 (Pin 5), IN3 (Pin 6), IN4 (Pin 7).</li>
                        <li><strong>GND:</strong> Unificar tierra del Arduino y la batería externa.</li>
                    </ul>
                </div>
            </div>

            <h2 class="mb-4">Pasos básicos</h2>
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="setup-step p-4 border rounded shadow-sm bg-white h-100">
                        <h4>1. Preparar</h4>
                        <p>Ensamblá el chasis, montá los motores y ajustá los sensores a 1 cm del suelo.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="setup-step p-4 border rounded shadow-sm bg-white h-100">
                        <h4>2. Programar</h4>
                        <p>Subí las reglas de decisión de los motores según las respuestas IR.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="setup-step p-4 border rounded shadow-sm bg-white h-100">
                        <h4>3. Probar</h4>
                        <p>Proba el vehículo sobre una pista blanca con pista dibujada en cinta aislante negra.</p>
                    </div>
                </div>
            </div>

            <h2 class="mt-5 mb-4">💻 Código Fuente</h2>
            <pre class="codigo"><code>const int sIzq = 2, sDer = 3;
const int IN1 = 4, IN2 = 5, IN3 = 6, IN4 = 7;

void setup() {
    pinMode(sIzq, INPUT); pinMode(sDer, INPUT);
    pinMode(IN1, OUTPUT); pinMode(IN2, OUTPUT);
    pinMode(IN3, OUTPUT); pinMode(IN4, OUTPUT);
}

void loop() {
    int valIzq = digitalRead(sIzq);
    int valDer = digitalRead(sDer);

    if (valIzq == LOW && valDer == LOW) { // Avanzar
        digitalWrite(IN1, HIGH); digitalWrite(IN2, LOW);
        digitalWrite(IN3, HIGH); digitalWrite(IN4, LOW);
    } else if (valIzq == HIGH && valDer == LOW) { // Giro Izquierda
        digitalWrite(IN1, LOW);  digitalWrite(IN2, LOW);
        digitalWrite(IN3, HIGH); digitalWrite(IN4, LOW);
    } else if (valIzq == LOW && valDer == HIGH) { // Giro Derecha
        digitalWrite(IN1, HIGH); digitalWrite(IN2, LOW);
        digitalWrite(IN3, LOW);  digitalWrite(IN4, LOW);
    } else { // Detener
        digitalWrite(IN1, LOW); digitalWrite(IN2, LOW);
        digitalWrite(IN3, LOW); digitalWrite(IN4, LOW);
    }
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