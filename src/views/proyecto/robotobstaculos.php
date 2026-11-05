<?php
session_start();
include __DIR__ . '/../conexion.php'; 

$id_proyecto_actual = 11;
$proyecto_completado = false;

if (isset($_SESSION['usuario']) && isset($conn)) {
    $nombre_usuario = $_SESSION['usuario'];
    $stmt_u = $conn->prepare('SELECT id_usuarios FROM usuarios WHERE nombre = ? LIMIT 1');
    $stmt_u->bind_param('s', $nombre_usuario);
    $stmt_u->execute();
    $res_u = $stmt_u->get_result()->fetch_assoc();
    
    if ($res_u) {
        $id_usuarios = $res_u['id_usuarios'];
        $stmt_prog = $conn->prepare('SELECT completado FROM progreso WHERE id_usuarios = ? AND id_proyecto = ? AND completado = 1 LIMIT 1');
        $stmt_prog->bind_param('ii', $id_usuarios, $id_proyecto_actual);
        $stmt_prog->execute();
        if ($stmt_prog->get_result()->num_rows > 0) {
            $proyecto_completado = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Vehículo autónomo esquivador de obstáculos con Arduino, controlador L298N y sensor ultrasónico HC-SR04.">
    <title>Robot Esquivador de Obstáculos - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="container section-container">
        <span class="tag-nivel intermedio">Intermedio</span>
        <h1 class="section-title">Robot Esquivador de Obstáculos</h1>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="project-info">
                    <h2>Explicación del Tutorial</h2>
                    <p>
                        Este tutorial integra robótica móvil con sensores de medición de distancia por ultrasonido. El móvil navega de forma continua midiendo el espacio frontal mediante un sensor HC-SR04. Cuando detecta un objeto a una distancia menor al umbral seguro, el algoritmo interrumpe el avance, ejecuta una maniobra de retroceso y realiza un giro lateral para continuar su trayectoria de forma totalmente autónoma.
                    </p>
                    <h3>Objetivo</h3>
                    <p>Aprender a controlar motores DC utilizando un puente H (módulo L298N), calcular distancias mediante impulsos ultrasónicos y programar rutinas de movimiento modularizadas mediante funciones de control.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-image">
                        <img src="../assets/img/robotobstaculos.jpg" alt="Componentes del proyecto Robot Esquivador de Obstáculos" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de componentes -->
        <section class="mt-5">
            <h2 class="mb-4">Lista de Componentes</h2>
            <div class="row g-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Placa de Desarrollo</h5>
                        <p class="mb-0">1x Arduino UNO (o compatible)</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Chasis y Tracción</h5>
                        <p class="mb-0">1x Chasis Robot 2WD<br>2x Motores DC con Ruedas</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Control y Sensores</h5>
                        <p class="mb-0">1x Controlador Módulo L298N<br>1x Sensor Ultrasónico HC-SR04</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Alimentación y Conexión</h5>
                        <p class="mb-0">1x Portapilas (7.4V a 12V)<br>1x Protoboard y Cables Jumper</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Conexión de cables -->
        <section class="mt-5">
            <h2 class="mb-4">Conexión de Cables</h2>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Componente</th>
                            <th>Pin del Componente</th>
                            <th>Pin en Arduino UNO / Conexión</th>
                            <th>Notas / Función</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="4"><strong>Controlador L298N</strong></td>
                            <td>IN1</td>
                            <td>Pin Digital 2</td>
                            <td>Control de dirección Motor Izquierdo (+)</td>
                        </tr>
                        <tr>
                            <td>IN2</td>
                            <td>Pin Digital 3</td>
                            <td>Control de dirección Motor Izquierdo (-)</td>
                        </tr>
                        <tr>
                            <td>IN3</td>
                            <td>Pin Digital 4</td>
                            <td>Control de dirección Motor Derecho (+)</td>
                        </tr>
                        <tr>
                            <td>IN4</td>
                            <td>Pin Digital 5</td>
                            <td>Control de dirección Motor Derecho (-)</td>
                        </tr>
                        <tr>
                            <td rowspan="4"><strong>Sensor Ultrasónico HC-SR04</strong></td>
                            <td>VCC</td>
                            <td>5V</td>
                            <td>Alimentación del sensor</td>
                        </tr>
                        <tr>
                            <td>GND</td>
                            <td>GND</td>
                            <td>Tierra común</td>
                        </tr>
                        <tr>
                            <td>Trig</td>
                            <td>Pin Digital 9</td>
                            <td>Disparo de pulso ultrasónico</td>
                        </tr>
                        <tr>
                            <td>Echo</td>
                            <td>Pin Digital 8</td>
                            <td>Recepción del eco ultrasónico</td>
                        </tr>
                        <tr>
                            <td rowspan="2"><strong>Alimentación Externa</strong></td>
                            <td>Positivo Batería (+)</td>
                            <td>Terminal 12V del L298N</td>
                            <td>Alimentación de potencia para motores</td>
                        </tr>
                        <tr>
                            <td>Negativo Batería (-)</td>
                            <td>GND del L298N y GND de Arduino</td>
                            <td>Masa y tierra común indispensable</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- CÓDIGO DE ARDUINO -->
        <section class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Código de Arduino (.ino)</h2>
                <button class="btn btn-sm btn-outline-primary" onclick="copiarCodigo()">Copiar Código</button>
            </div>
            <div class="card bg-dark text-light p-3 border-0 rounded-3">
                <pre class="mb-0"><code id="codigoArduino">// Pines del Sensor Ultrasónico HC-SR04
const int trigPin = 9;
const int echoPin = 8;

// Pines de Control de Movimiento (Controlador L298N)
const int motorIzquierda1 = 2;
const int motorIzquierda2 = 3;
const int motorDerecha1 = 4;
const int motorDerecha2 = 5;

const int umbralDistancia = 20; // Límite de cercanía en centímetros

void setup() {
  // Configuración de pines del sensor
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);

  // Configuración de pines de los motores
  pinMode(motorIzquierda1, OUTPUT);
  pinMode(motorIzquierda2, OUTPUT);
  pinMode(motorDerecha1, OUTPUT);
  pinMode(motorDerecha2, OUTPUT);
}

void loop() {
  long duracion;
  int distancia;

  // Emisión de pulso ultrasónico
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);

  // Lectura del tiempo de retorno del pulso
  duracion = pulseIn(echoPin, HIGH);
  distancia = duracion * 0.034 / 2; // Conversión a centímetros

  // Algoritmo de detección y maniobra
  if (distancia > 0 && distancia < umbralDistancia) {
    detener();
    delay(200);
    retroceder();
    delay(400);
    girarIzquierda();
    delay(500);
  } else {
    avanzar();
  }
}

// Subrutinas de control de motores
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

        <!-- Descripción paso por paso -->
        <section class="mt-5">
            <h2 class="mb-4">Descripción Paso por Paso</h2>
            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>1. Montaje del Chasis</h4>
                        <p>Ensamblá la estructura mecánica del robot, fijá los dos motores DC con sus ruedas y posicioná el controlador L298N, la placa Arduino y el sensor ultrasónico al frente.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>2. Cableado Eléctrico</h4>
                        <p>Conectá las salidas del driver L298N hacia los motores, uní las entradas de control (IN1-IN4) alos pines 2 a 5 del Arduino y asegurá la masa común (GND) entre las baterías y el Arduino.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>3. Carga del Código</h4>
                        <p>Conectá el Arduino vía USB a tu computadora, abrí el Arduino IDE, seleccioná la placa <em>Arduino UNO</em> y el puerto COM asignado, y cargá el sketch del robot.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>4. Prueba de Navegación</h4>
                        <p>Desconectá el cable USB, encendé la fuente de energía externa del robot y colocalo en el suelo. Interponé objetos a menos de 20 cm para verificar las maniobras de esquivo autónomo.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Botones de navegación y completado -->
        <div class="text-center button-container my-5 d-flex justify-content-center gap-3 flex-wrap">
            <a href="../proyectos.php" class="btn btn-outline-cyan">← Volver a Proyectos</a>
            <button id="btnCompletar" 
                    class="btn <?= $proyecto_completado ? 'btn-success' : 'btn-outline-success' ?>" 
                    data-proyecto-id="<?= $id_proyecto_actual ?>" 
                    <?= $proyecto_completado ? 'disabled' : '' ?>>
                <?= $proyecto_completado ? '✓ Completado' : 'Marcar como completado' ?>
            </button>
        </div>
    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copiarCodigo() {
            const codigo = document.getElementById('codigoArduino').innerText;
            navigator.clipboard.writeText(codigo).then(() => {
                alert('¡Código copiado al portapapeles!');
            });
        }
        
        document.addEventListener("DOMContentLoaded", () => {
            const btnCompletar = document.getElementById("btnCompletar");

            if (!btnCompletar) {
                console.error("No se encontró el botón con id 'btnCompletar'.");
                return;
            }

            btnCompletar.addEventListener("click", async () => {
                const idProyecto = btnCompletar.getAttribute("data-proyecto-id");
                console.log("Enviando ID de proyecto:", idProyecto);

                try {
                    const res = await fetch("../guardar_progreso.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id_proyecto: idProyecto })
                    });

                    const textoRespuesta = await res.text();
                    console.log("Respuesta del servidor:", textoRespuesta);

                    let resultado;
                    try {
                        resultado = JSON.parse(textoRespuesta);
                    } catch (e) {
                        throw new Error("El servidor no devolvió un JSON válido. Respuesta: " + textoRespuesta);
                    }

                    if (resultado.ok) {
                        btnCompletar.textContent = "✓ Completado";
                        btnCompletar.classList.remove("btn-outline-success");
                        btnCompletar.classList.add("btn-success");
                        btnCompletar.disabled = true;
                    } else {
                        alert("Error del servidor: " + (resultado.mensaje || "Desconocido"));
                    }
                } catch (err) {
                    console.error("Error en el fetch:", err);
                    alert("Error de conexión: " + err.message);
                }
            });
        });
    </script>
</body>

</html>