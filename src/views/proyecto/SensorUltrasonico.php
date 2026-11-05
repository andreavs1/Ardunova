<?php
session_start();
include __DIR__ . '/../conexion.php'; 

$id_proyecto_actual = 4;
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
    <meta name="description" content="Medición de distancia mediante un sensor ultrasónico HC-SR04 conectado a Arduino.">
    <title>Sensor Ultrasónico de Distancia - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="container section-container">
        <span class="tag-nivel intermedio">Intermedio</span>
        <h1 class="section-title">Sensor Ultrasónico de Distancia</h1>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="project-info">
                    <h2>Explicación del Tutorial</h2>
                    <p>
                        Este tutorial aborda la medición de distancias sin contacto utilizando el sensor ultrasónico HC-SR04. El módulo emite un pulso de sonido de alta frecuencia a través de un emisor y mide el tiempo que tarda en rebotar y regresar al receptor. Con esta lectura de tiempo y la velocidad conocida del sonido en el aire, el Arduino calcula la distancia exacta hacia los objetos en centímetros.
                    </p>
                    <h3>Objetivo</h3>
                    <p>Comprender el principio de funcionamiento de los sensores ecolocalizadores, medir tiempos de respuesta exactos con la función <code>pulseIn()</code> y procesar fórmulas físicas simples para obtener la distancia en tiempo real.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-image text-center p-3">
                        <img src="../assets/img/ultrasonico.jpg" alt="Sensor Ultrasónico" class="img-fluid rounded">
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
                        <h5>Sensores Ultrasónicos</h5>
                        <p class="mb-0">1x Sensor Ultrasónico HC-SR04</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Conectividad</h5>
                        <p class="mb-0">4x Cables Jumper Macho-Hembra (o M-M)</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Auxiliares</h5>
                        <p class="mb-0">1x Protoboard y Cable USB de programación</p>
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
                            <th>Pin en Arduino UNO</th>
                            <th>Notas / Función</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="4"><strong>Sensor Ultrasónico (HC-SR04)</strong></td>
                            <td>VCC</td>
                            <td>5V</td>
                            <td>Alimentación principal (5V)</td>
                        </tr>
                        <tr>
                            <td>Trig (Disparo)</td>
                            <td>Pin Digital 9</td>
                            <td>Emisión de señal/pulso de ultrasonido</td>
                        </tr>
                        <tr>
                            <td>Echo (Eco)</td>
                            <td>Pin Digital 8</td>
                            <td>Recepción del pulso de rebote</td>
                        </tr>
                        <tr>
                            <td>GND</td>
                            <td>GND</td>
                            <td>Tierra común</td>
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
                <pre class="mb-0"><code id="codigoArduino">// Definición de pines para el HC-SR04
const int pinTrig = 9;
const int pinEcho = 8;

void setup() {
  pinMode(pinTrig, OUTPUT); // Pin Trig configurado como salida de señal
  pinMode(pinEcho, INPUT);  // Pin Echo configurado como entrada de rebote
  
  Serial.begin(9600);       // Inicia la comunicación serie a 9600 baudios
  Serial.println("Sensor Ultrasonico HC-SR04 Inicializado.");
}

void loop() {
  long duracion;
  int distancia;

  // Generación de un pulso limpio en Trig (2us LOW, 10us HIGH)
  digitalWrite(pinTrig, LOW);
  delayMicroseconds(2);
  digitalWrite(pinTrig, HIGH);
  delayMicroseconds(10);
  digitalWrite(pinTrig, LOW);

  // Lectura del tiempo en microsegundos que tarda en regresar el eco
  duracion = pulseIn(pinEcho, HIGH);

  // Cálculo de distancia: (Tiempo x Velocidad del Sonido 0.034 cm/us) / 2 (ida y vuelta)
  distancia = duracion * 0.034 / 2;

  // Envío de la medición hacia la consola serie
  Serial.print("Distancia medida: ");
  Serial.print(distancia);
  Serial.println(" cm");

  delay(200); // Pausa breve entre mediciones
}</code></pre>
            </div>
        </section>

        <!-- Descripción paso por paso -->
        <section class="mt-5">
            <h2 class="mb-4">Descripción Paso por Paso</h2>
            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>1. Montaje del Circuito</h4>
                        <p>Colocá el módulo HC-SR04 en la protoboard. Conectá el pin VCC a 5V, GND a GND, el pin Trig al pin digital 9 y el pin Echo al pin digital 8 del Arduino.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>2. Carga del Código</h4>
                        <p>Conectá la placa por USB a tu computadora, abrí el entorno Arduino IDE, copiá y pegá el código provisto, seleccioná la placa <em>Arduino UNO</em> y presioná **Subir**.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>3. Apertura del Monitor Serie</h4>
                        <p>Abrí el Monitor Serie dentro de Arduino IDE (Ctrl + Shift + M) asegurándote de tener la velocidad configurada a 9600 baudios para recibir las lecturas de distancia.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>4. Prueba de Mediciones</h4>
                        <p>Desplazá un objeto rígido o tu mano hacia adelante y hacia atrás frente al sensor HC-SR04. Comprobá cómo la distancia en centímetros cambia en tiempo real en la pantalla.</p>
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