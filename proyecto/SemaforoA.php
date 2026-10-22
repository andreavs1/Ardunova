<?php session_start(); $active_page = 'proyectos'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Diseño funcional de un semáforo con Arduino y temporizaciones secuenciales.">
    <title>Semáforo Inteligente - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container section-container">
    <div class="contenedor">
        <span class="tag-nivel intermedio">Intermedio</span>
        <h1 class="section-title">🚦 Semáforo Avanzado con Paso Peatonal</h1>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="project-info">
                    <h2>Sobre el proyecto</h2>
                    <p>Evolución del semáforo básico que integra control sincronizado para vehículos y peatones junto a un pulsador de demanda de paso.</p>
                    <h3>Objetivo</h3>
                    <p>Implementar interrupciones por software, detección de estados en pulsadores y sincronización estricta de tiempos de tráfico.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-image text-center p-3">
                        <img src="<?= BASE_URL ?>assets/img/semaforo-arduino.png" alt="Semáforo Avanzado" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-5">
            <h2 class="mb-4">🧰 Componentes necesarios</h2>
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item">1x Placa Arduino UNO</li>
                <li class="list-group-item">2x LEDs Rojos, 1x Amarillo, 2x Verdes</li>
                <li class="list-group-item">5x Resistencias de 220Ω</li>
                <li class="list-group-item">1x Pulsador (Push Button) + Resistencia 10kΩ</li>
                <li class="list-group-item">Protoboard y jumpers</li>
            </ul>

            <h2 class="mb-4">🔌 Esquema de conexión</h2>
            <div class="card my-3">
                <div class="card-body">
                    <ul>
                        <li><strong>Semáforo Vehicular:</strong> Verde (Pin 10), Amarillo (Pin 9), Rojo (Pin 8).</li>
                        <li><strong>Semáforo Peatonal:</strong> Verde (Pin 6), Rojo (Pin 7).</li>
                        <li><strong>Pulsador Peatón:</strong> Pin Digital 2 (con resistencia Pull-Down a GND).</li>
                    </ul>
                </div>
            </div>

            <h2 class="mb-4">Pasos básicos</h2>
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="setup-step p-4 border rounded shadow-sm bg-white h-100">
                        <h4>1. Preparar</h4>
                        <p>Armá el circuito para ambos juegos de semáforos y conectá el botón de cruce.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="setup-step p-4 border rounded shadow-sm bg-white h-100">
                        <h4>2. Programar</h4>
                        <p>Subí el código y configurá la lectura del estado del botón digital.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="setup-step p-4 border rounded shadow-sm bg-white h-100">
                        <h4>3. Probar</h4>
                        <p>Presioná el botón para solicitar el paso peatonal y verificá la transición segura.</p>
                    </div>
                </div>
            </div>

            <h2 class="mt-5 mb-4">💻 Código Fuente</h2>
            <pre class="codigo"><code>const int vVehiculo = 10, aVehiculo = 9, rVehiculo = 8;
const int vPeaton = 6, rPeaton = 7;
const int boton = 2;

void setup() {
    pinMode(vVehiculo, OUTPUT); pinMode(aVehiculo, OUTPUT); pinMode(rVehiculo, OUTPUT);
    pinMode(vPeaton, OUTPUT); pinMode(rPeaton, OUTPUT);
    pinMode(boton, INPUT);
}

void loop() {
    digitalWrite(vVehiculo, HIGH);
    digitalWrite(rPeaton, HIGH);

    if (digitalRead(boton) == HIGH) {
        delay(1000);
        digitalWrite(vVehiculo, LOW);
        digitalWrite(aVehiculo, HIGH);
        delay(2000);
        digitalWrite(aVehiculo, LOW);
        digitalWrite(rVehiculo, HIGH);
        
        digitalWrite(rPeaton, LOW);
        digitalWrite(vPeaton, HIGH);
        delay(5000);
        
        digitalWrite(vPeaton, LOW);
        digitalWrite(rPeaton, HIGH);
        digitalWrite(rVehiculo, LOW);
    }
}
</code></pre>
        </section>

        <div class="text-center button-container my-4">
            <a href="<?= BASE_URL ?>proyecto/proyectos.php" class="btn btn-outline-cyan">← Volver a Proyectos</a>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>