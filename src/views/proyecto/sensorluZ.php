<?php
session_start();
include __DIR__ . '/../conexion.php'; 

$id_proyecto_actual = 8;
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

$active_page = 'proyectos'; 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aprende a medir la intensidad de luz ambiental con un sensor LDR y controlar un LED en función de la luminosidad con Arduino.">
    <title>Sensor de Luz (LDR) - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="container section-container">
        <span class="tag-nivel principiante">Principiante</span>
        <h1 class="section-title">Sensor de Luz (LDR)</h1>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="project-info">
                    <h2>Explicación del Tutorial</h2>
                    <p>
                        Este proyecto enseña a medir la cantidad de luz ambiental mediante una fotorresistencia (LDR). A medida que cambia la luminosidad del entorno, la resistencia eléctrica del sensor varía. Mediante un divisor de tensión, convertimos este cambio en una variación de voltaje que el Arduino lee a través de una entrada analógica para encender un LED o luz de respaldo automáticamente en la oscuridad.
                    </p>
                    <h3>Objetivo</h3>
                    <p>Comprender la configuración de un divisor de voltaje con componentes fotosensibles, utilizar entradas analógicas con <code>analogRead()</code> y automatizar el encendido de un sistema de iluminación nocturna.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-image">
                        <img src="../assets/img/sensorLuz.jpg" alt="Componentes del proyecto Sensor de Luz LDR" class="img-fluid rounded">
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
                        <h5>Sensores Fotosensibles</h5>
                        <p class="mb-0">1x Fotorresistencia (LDR)</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Actuadores y Resistencias</h5>
                        <p class="mb-0">1x LED estándar (5mm)<br>1x Resistencia de 10kΩ<br>1x Resistencia de 220Ω</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Auxiliares</h5>
                        <p class="mb-0">1x Protoboard y Cables Jumper Macho-Macho</p>
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
                            <th>Pin / Terminal</th>
                            <th>Pin en Arduino UNO</th>
                            <th>Notas / Función</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="2"><strong>Fotorresistencia (LDR)</strong></td>
                            <td>Terminal 1</td>
                            <td>5V</td>
                            <td>Alimentación del divisor de tensión</td>
                        </tr>
                        <tr>
                            <td>Terminal 2</td>
                            <td>Pin Analógico A0 (con R 10kΩ a GND)</td>
                            <td>Punto medio para la lectura del voltaje analógico</td>
                        </tr>
                        <tr>
                            <td><strong>Resistencia 10kΩ</strong></td>
                            <td>Entre LDR Terminal 2 y GND</td>
                            <td>GND</td>
                            <td>Completa el divisor de tensión para estabilizar la señal</td>
                        </tr>
                        <tr>
                            <td rowspan="2"><strong>LED (5mm)</strong></td>
                            <td>Ánodo (pata larga, +)</td>
                            <td>Pin Digital 13</td>
                            <td>Salida digital de control del indicador de luz</td>
                        </tr>
                        <tr>
                            <td>Cátodo (pata corta, -)</td>
                            <td>GND (a través de R 220Ω)</td>
                            <td>Conexión a masa con resistencia de protección</td>
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
                <pre class="mb-0"><code id="codigoArduino">const int pinLDR = A0;      // Pin analógico donde se conecta la LDR
const int pinLED = 13;      // Pin digital del LED
int umbralOscuridad = 500;  // Valor umbral para encender la luz (Ajustable)

void setup() {
  pinMode(pinLED, OUTPUT);
  Serial.begin(9600);       // Inicia comunicación serie a 9600 baudios
}

void loop() {
  int valorLuz = analogRead(pinLDR); // Lee la intensidad de luz (0 a 1023)

  Serial.print("Nivel de luz registrado: ");
  Serial.println(valorLuz);

  // Cuando disminuye la luz, la lectura del divisor baja
  if (valorLuz < umbralOscuridad) {
    digitalWrite(pinLED, HIGH);  // Enciende el LED en la oscuridad
    Serial.println("--> Estado: OSCURIDAD DETECTADA (LED Encendido)");
  } else {
    digitalWrite(pinLED, LOW);   // Apaga el LED cuando hay buena iluminación
    Serial.println("--> Estado: LUZ SUFICIENTE (LED Apagado)");
  }

  delay(500); // Pausa para estabilidad en las lecturas
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
                        <p>Armá el divisor de tensión conectando un terminal de la LDR a 5V y el otro terminal al pin A0 junto con la resistencia de 10kΩ a GND. Conectá el LED al pin 13 con su resistencia de 220Ω.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>2. Carga del Sketch</h4>
                        <p>Abrí Arduino IDE, pegá el código en un nuevo proyecto, seleccioná la placa <em>Arduino UNO</em> en la pestaña de Herramientas y el puerto COM asignado, y presioná <strong>Subir</strong>.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>3. Monitoreo e Inspección</h4>
                        <p>Abrí el Monitor Serie (a 9600 baudios) para revisar los valores en tiempo real. Observá cómo disminuye el valor leído cuando tapas la LDR con la mano.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>4. Calibración y Prueba</h4>
                        <p>Cubrí completamente el sensor para simular la noche y comprobá que el LED se encienda automáticamente. Si la luz ambiente cambia, ajustá el valor de la variable <code>umbralOscuridad</code> en el código.</p>
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