<?php
session_start();
include __DIR__ . '/../conexion.php'; 

$id_proyecto_actual = 9;
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
    <meta name="description" content="Sistema de riego automático con sensor de humedad de suelo, relé y bomba de agua controlado por Arduino.">
    <title>Sistema de Riego Automático - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="container section-container">
        <span class="tag-nivel avanzado">Avanzado</span>
        <h1 class="section-title">Sistema de Riego Automático</h1>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="project-info">
                    <h2>Explicación del Tutorial</h2>
                    <p>
                        Este tutorial enseña a construir un sistema de automatización agrícola a pequeña escala. Aprenderás a monitorear el nivel de humedad presente en el sustrato mediante un sensor higrómetro (YL-69 / FC-28) y a procesar esas lecturas analógicas con Arduino para activar automáticamente una bomba de agua a través de un módulo relé cuando la tierra se encuentre seca.
                    </p>
                    <h3>Objetivo</h3>
                    <p>Comprender el acondicionamiento de señales analógicas en sensores de suelo, calibrar umbrales de activación según el tipo de plantas y controlar cargas de potencia de forma segura mediante relés.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-image">
                        <img src="../assets/img/sistemaDeRiego.jpg" alt="Componentes del proyecto Riego Automático" class="img-fluid rounded">
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
                        <h5>Sensores</h5>
                        <p class="mb-0">1x Sensor de humedad de suelo (YL-69 o FC-28)</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Actuadores y Bomba</h5>
                        <p class="mb-0">1x Módulo Relé de 1 Canal (5V)<br>1x Mini bomba de agua sumergible (5V - 12V)</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Alimentación y Cables</h5>
                        <p class="mb-0">1x Fuente externa para la bomba<br>1x Protoboard y Cables Jumper M-M / M-H</p>
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
                            <td rowspan="3"><strong>Sensor de Humedad (YL-69/FC-28)</strong></td>
                            <td>VCC</td>
                            <td>5V</td>
                            <td>Alimentación del módulo comparador</td>
                        </tr>
                        <tr>
                            <td>GND</td>
                            <td>GND</td>
                            <td>Tierra común</td>
                        </tr>
                        <tr>
                            <td>AO (Salida Analógica)</td>
                            <td>Pin Analógico A0</td>
                            <td>Lectura de humedad del suelo (0 a 1023)</td>
                        </tr>
                        <tr>
                            <td rowspan="3"><strong>Módulo Relé (5V)</strong></td>
                            <td>VCC</td>
                            <td>5V</td>
                            <td>Alimentación del relé</td>
                        </tr>
                        <tr>
                            <td>GND</td>
                            <td>GND</td>
                            <td>Tierra común</td>
                        </tr>
                        <tr>
                            <td>IN (Entrada de Control)</td>
                            <td>Pin Digital 7</td>
                            <td>Señal digital para activar/desactivar el relé</td>
                        </tr>
                        <tr>
                            <td rowspan="2"><strong>Mini Bomba de Agua</strong></td>
                            <td>Cable Positivo (+)</td>
                            <td>Terminal NO (Normal Open) del Relé</td>
                            <td>Circuito de alimentación de la bomba interumpido por el relé</td>
                        </tr>
                        <tr>
                            <td>Cable Negativo (-)</td>
                            <td>GND de la Fuente Externa</td>
                            <td>Cierre del circuito de la bomba externa</td>
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
                <pre class="mb-0"><code id="codigoArduino">const int sensorPin = A0;   // Pin analógico donde se conecta el sensor de humedad
const int relePin = 7;      // Pin digital de control para el módulo relé
int umbralHumedad = 500;    // Valor umbral (Ajustar según la humedad deseada)

void setup() {
  pinMode(relePin, OUTPUT);
  digitalWrite(relePin, HIGH); // La mayoría de los relés apagan con nivel ALTO (HIGH)
  
  Serial.begin(9600);          // Inicia comunicación serie para monitoreo
  Serial.println("Sistema de Riego Automatico Inicializado.");
}

void loop() {
  int valorSensor = analogRead(sensorPin); // Lee la humedad (Valores altos = Tierra Seca)

  Serial.print("Valor de humedad de suelo: ");
  Serial.println(valorSensor);

  // Si la lectura supera el umbral significa que la tierra está seca
  if (valorSensor > umbralHumedad) {
    digitalWrite(relePin, LOW);    // Activa el relé (Enciende la bomba de agua)
    Serial.println("--> Estado: Tierra seca. Riego ACTIVADO.");
  } else {
    digitalWrite(relePin, HIGH);   // Desactiva el relé (Apaga la bomba de agua)
    Serial.println("--> Estado: Tierra humeda. Riego APAGADO.");
  }

  delay(2000); // Pausa de 2 segundos entre mediciones
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
                        <p>Conectá los pines VCC y GND del sensor de humedad y del módulo relé a las líneas correspondientes. Uní la salida analógica (AO) del sensor al pin A0 y la entrada del relé (IN) al pin digital 7.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>2. Conexión de la Bomba</h4>
                        <p>Interrumpe el cable positivo de la fuente de la bomba pasándolo a través de los terminales Común (COM) y Normal Abierto (NO) del relé para aislar la potencia de la placa Arduino.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>3. Carga y Calibración</h4>
                        <p>Subí el programa a tu Arduino. Abrí el Monitor Serie (9600 baudios) e insertá las puntas del sensor en tierra seca y luego húmeda para determinar el valor del <code>umbralHumedad</code> adecuado.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>4. Prueba de Funcionamiento</h4>
                        <p>Insertá las puntas del sensor en tierra seca: verás que el relé se activa y la bomba riega el sustrato. Al humedecerse la tierra, el sistema detendrá el riego automáticamente.</p>
                    </div>
                </div>
            </div>
        </section>

       <div class="text-center button-container my-5 d-flex justify-content-center gap-3 flex-wrap">
            <a href="../proyectos.php" class="btn btn-outline-cyan">← Volver a Proyectos</a>
            <button id="btnCompletar" 
        class="btn <?= $proyecto_completado ? 'btn-success' : 'btn-outline-success' ?>" 
        data-proyecto-id="<?= $id_proyecto_actual ?>" 
        <?= $proyecto_completado ? 'disabled' : '' ?>>
    <?= $proyecto_completado ? '✓ Completado' : 'Marcar como completado' ?>
</button>

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
