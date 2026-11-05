<?php
session_start();
include __DIR__ . '/../conexion.php'; 

$id_proyecto_actual = 10;
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
    <meta name="description" content="Aprende a construir un robot móvil autónomo seguidor de línea negra con sensores infrarrojos TCRT5000 y Arduino.">
    <title>Auto Seguidor de Línea - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="container section-container">
        <span class="tag-nivel intermedio">Intermedio</span>
        <h1 class="section-title">Auto Seguidor de Línea</h1>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="project-info">
                    <h2>Explicación del Tutorial</h2>
                    <p>
                        Este tutorial aborda el desarrollo de un vehículo robótico autónomo diseñado para rastrear y seguir una pista delimitada por una línea negra sobre una superficie clara. A través de sensores infrarrojos (TCRT5000 / módulos de rastreo) que detectan la diferencia de reflectancia de la luz, el circuito procesa las lecturas en tiempo real y ajusta la velocidad e itinerario de los motores mediante el puente H (driver L298N) para mantener el vehículo centrado sobre el trayecto.
                    </p>
                    <h3>Objetivo</h3>
                    <p>Comprender el principio de reflexión de luz en sensores ópticos infrarrojos, procesar entradas digitales/analógicas de contraste y controlar la tracción diferencial de motores para ajustar la trayectoria.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-image">
                        <img src="../assets/img/seguidorLinea.jpg" alt="Componentes del proyecto Auto Seguidor de Línea" class="img-fluid rounded">
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
                        <p class="mb-0">1x Driver L298N o L293D<br>2x Módulos Sensor Infrarrojo TCRT5000</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Alimentación y Conexión</h5>
                        <p class="mb-0">1x Portapilas/Batería (7.4V - 12V)<br>1x Protoboard y Cables Jumper</p>
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
                            <td>Sentido de Giro Motor Izquierdo (+)</td>
                        </tr>
                        <tr>
                            <td>IN2</td>
                            <td>Pin Digital 3</td>
                            <td>Sentido de Giro Motor Izquierdo (-)</td>
                        </tr>
                        <tr>
                            <td>IN3</td>
                            <td>Pin Digital 4</td>
                            <td>Sentido de Giro Motor Derecho (+)</td>
                        </tr>
                        <tr>
                            <td>IN4</td>
                            <td>Pin Digital 5</td>
                            <td>Sentido de Giro Motor Derecho (-)</td>
                        </tr>
                        <tr>
                            <td rowspan="3"><strong>Sensor IR Izquierdo</strong></td>
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
                            <td>DO (Digital Out)</td>
                            <td>Pin Digital 8</td>
                            <td>Lectura óptica del lado izquierdo</td>
                        </tr>
                        <tr>
                            <td rowspan="3"><strong>Sensor IR Derecho</strong></td>
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
                            <td>DO (Digital Out)</td>
                            <td>Pin Digital 9</td>
                            <td>Lectura óptica del lado derecho</td>
                        </tr>
                        <tr>
                            <td rowspan="2"><strong>Fuente de Energía Externa</strong></td>
                            <td>Positivo Batería (+)</td>
                            <td>Terminal 12V del L298N</td>
                            <td>Alimentación principal para los motores DC</td>
                        </tr>
                        <tr>
                            <td>Negativo Batería (-)</td>
                            <td>GND del L298N y GND del Arduino</td>
                            <td>Masa/Tierra común entre circuito lógico y potencia</td>
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
                <pre class="mb-0"><code id="codigoArduino">// Pines de control del Driver de Motores (L298N)
const int IN1 = 2; // Motor Izquierdo
const int IN2 = 3;
const int IN3 = 4; // Motor Derecho
const int IN4 = 5;

// Pines de los Sensores Infrarrojos TCRT5000
const int sensorIzquierdo = 8;
const int sensorDerecho = 9;

void setup() {
  // Configuración de pines para el driver de motores
  pinMode(IN1, OUTPUT);
  pinMode(IN2, OUTPUT);
  pinMode(IN3, OUTPUT);
  pinMode(IN4, OUTPUT);

  // Configuración de pines de entrada para los sensores IR
  pinMode(sensorIzquierdo, INPUT);
  pinMode(sensorDerecho, INPUT);
}

void loop() {
  // Lectura del estado digital de los sensores (HIGH = Línea Negra / LOW = Fondo Blanco)
  int estadoIzquierdo = digitalRead(sensorIzquierdo);
  int estadoDerecho = digitalRead(sensorDerecho);

  // Caso 1: Ambos sensores ven blanco -> Avanzar recto
  if (estadoIzquierdo == LOW && estadoDerecho == LOW) {
    avanzar();
  }
  // Caso 2: El sensor izquierdo detecta la línea negra -> Girar a la izquierda
  else if (estadoIzquierdo == HIGH && estadoDerecho == LOW) {
    girarIzquierda();
  }
  // Caso 3: El sensor derecho detecta la línea negra -> Girar a la derecha
  else if (estadoIzquierdo == LOW && estadoDerecho == HIGH) {
    girarDerecha();
  }
  // Caso 4: Ambos sensores detectan la línea negra o salida -> Detener
  else if (estadoIzquierdo == HIGH && estadoDerecho == HIGH) {
    detener();
  }
}

// Subrutinas para el control de tracción
void avanzar() {
  digitalWrite(IN1, HIGH);
  digitalWrite(IN2, LOW);
  digitalWrite(IN3, HIGH);
  digitalWrite(IN4, LOW);
}

void girarIzquierda() {
  digitalWrite(IN1, LOW);
  digitalWrite(IN2, LOW);
  digitalWrite(IN3, HIGH);
  digitalWrite(IN4, LOW);
}

void girarDerecha() {
  digitalWrite(IN1, HIGH);
  digitalWrite(IN2, LOW);
  digitalWrite(IN3, LOW);
  digitalWrite(IN4, LOW);
}

void detener() {
  digitalWrite(IN1, LOW);
  digitalWrite(IN2, LOW);
  digitalWrite(IN3, LOW);
  digitalWrite(IN4, LOW);
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
                        <p>Ensamblá las ruedas y los motores DC sobre el chasis. Posicioná los dos sensores infrarrojos mirando hacia abajo en la parte frontal, separados a una distancia ligeramente superior al ancho de la línea negra.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>2. Cableado del Circuito</h4>
                        <p>Conectá las señales de control IN1 a IN4 al Arduino y las salidas digitales de los sensores a los pines 8 y 9. Verificá que la tierra (GND) de la batería externa esté unida con la masa del Arduino.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>3. Carga y Calibración</h4>
                        <p>Cargá el código en la placa Arduino. Colocá el vehículo sobre una superficie blanca con la línea negra en el medio y ajustá los potenciómetros integrados en cada módulo IR hasta que los LED indicativos reaccionen al contraste.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>4. Prueba en Pista</h4>
                        <p>Conectá la fuente externa para activar los motores y colocá el robot sobre la pista. Observá cómo corrige su dirección de manera automática al aproximarse a las curvas para mantenerse sobre la línea.</p>
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