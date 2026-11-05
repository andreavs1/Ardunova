<?php
session_start();
include __DIR__ . '/../conexion.php'; 

$id_proyecto_actual = 6;
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
    <meta name="description" content="Control de un LED mediante la lectura de un pulsador con Arduino.">
    <title>Control de LED con Pulsador - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="container section-container">
        <span class="tag-nivel principiante">Principiante</span>
        <h1 class="section-title">Control de LED con Pulsador</h1>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="project-info">
                    <h2>Explicación del Tutorial</h2>
                    <p>
                        Este proyecto enseña los fundamentos de las entradas digitales en microcontroladores. Aprenderás a leer el estado de un pulsador (Push Button) utilizando una resistencia Pull-Down para garantizar una señal limpia, y a procesar ese dato en tiempo real para activar una salida digital que encienda un LED mientras el botón permanece presionado.
                    </p>
                    <h3>Objetivo</h3>
                    <p>Comprender la diferencia entre señales de entrada y salida digital, implementar configuraciones de resistencias Pull-Down y utilizar condicionales (if/else) en el código de Arduino.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-image">
                        <img src="../assets/img/ledBoton.jpg" alt="Componentes del proyecto LED con Pulsador" class="img-fluid rounded">
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
                        <h5>Actuadores / Luz</h5>
                        <p class="mb-0">1x LED estándar (5mm)</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Entradas y Resistencias</h5>
                        <p class="mb-0">1x Pulsador (Push Button)<br>1x Resistencia 220Ω (para LED)<br>1x Resistencia 10kΩ (Pull-down)</p>
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
                            <td rowspan="2"><strong>LED (5mm)</strong></td>
                            <td>Ánodo (pata larga, +)</td>
                            <td>Pin Digital 13</td>
                            <td>Salida digital de control</td>
                        </tr>
                        <tr>
                            <td>Cátodo (pata corta, -)</td>
                            <td>GND (a través de R 220Ω)</td>
                            <td>Conexión a masa con resistencia limitadora</td>
                        </tr>
                        <tr>
                            <td rowspan="2"><strong>Pulsador (Push Button)</strong></td>
                            <td>Terminal A</td>
                            <td>5V</td>
                            <td>Alimentación del circuito de entrada</td>
                        </tr>
                        <tr>
                            <td>Terminal B</td>
                            <td>Pin Digital 2 (con R 10kΩ a GND)</td>
                            <td>Lectura digital con resistencia Pull-Down</td>
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
                <pre class="mb-0"><code id="codigoArduino">const int botonPin = 2; // Pin digital donde conectamos el pulsador
const int ledPin = 13;   // Pin digital donde conectamos el LED

int estadoBoton = 0;     // Variable para almacenar el estado del pulsador

void setup() {
  pinMode(ledPin, OUTPUT);  // Configura el pin 13 como salida
  pinMode(botonPin, INPUT); // Configura el pin 2 como entrada
}

void loop() {
  // Lee si el pulsador está presionado (HIGH) o no (LOW)
  estadoBoton = digitalRead(botonPin);

  // Si el botón está presionado, enciende el LED
  if (estadoBoton == HIGH) {
    digitalWrite(ledPin, HIGH); // Enciende el LED
  } else {
    digitalWrite(ledPin, LOW);  // Apaga el LED
  }
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
                        <p>Insertá el pulsador y el LED en la protoboard. Conectá el LED al pin 13 con la resistencia de 220Ω a GND. Uní un extremo del botón a 5V y el otro al pin 2 junto con la resistencia de 10kΩ a GND.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>2. Preparación del Software</h4>
                        <p>Abrí Arduino IDE, creá un nuevo sketch, copiá el código provisto arriba y seleccioná la placa <em>Arduino UNO</em> en la pestaña de herramientas junto al puerto COM correspondiente.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>3. Carga del Programa</h4>
                        <p>Hacé clic en el botón **Subir** para compilar y transferir el programa a tu placa Arduino. Verificá que el proceso termine sin errores.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>4. Prueba de Funcionamiento</h4>
                        <p>Presioná y mantené el pulsador para comprobar que el LED se encienda instantáneamente. Al soltar el botón, el LED deberá apagarse inmediatamente.</p>
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