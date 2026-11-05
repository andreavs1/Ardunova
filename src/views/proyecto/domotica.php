<?php
session_start();
include __DIR__ . '/../conexion.php'; 

$id_proyecto_actual = 5; // ID correspondiente a Domótica Básica en proyectos.json
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
    <meta name="description" content="Automatización básica de luces y sensores para iniciarse en domótica con Arduino.">
    <title>Domótica Básica - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="container section-container">
        <span class="tag-nivel intermedio">Intermedio</span>
        <h1 class="section-title">Domótica Básica</h1>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="project-info">
                    <h2>Explicación del Tutorial</h2>
                    <p>
                        Este tutorial aborda las bases de la domótica mediante el desarrollo de un sistema de control de iluminación y monitoreo de presencia con Arduino. Aprenderás a encender o apagar cargas mediante un módulo relé (simulando focos o luces del hogar) utilizando la lectura de sensores de presencia PIR y fotorresistencias (LDR), así como el control vía Serial.
                    </p>
                    <h3>Objetivo</h3>
                    <p>Comprender la lógica de integración entre sensores de entorno y actuadores de potencia, programar la placa Arduino y verificar el funcionamiento completo del sistema automatizado.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100">
                    <div class="card-image">
                        <img src="../assets/img/domotica.jpg" alt="Domótica Básica" class="img-fluid rounded">
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
                        <h5>Actuadores</h5>
                        <p class="mb-0">1x Módulo Relé de 1 o 2 Canales (5V)</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Sensores</h5>
                        <p class="mb-0">1x Sensor PIR (HC-SR501)<br>1x Fotorresistencia LDR</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Auxiliares</h5>
                        <p class="mb-0">1x Resistencia 10kΩ<br>1x Protoboard y Cables Jumper</p>
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
                            <td rowspan="3"><strong>Módulo Relé (5V)</strong></td>
                            <td>VCC</td>
                            <td>5V</td>
                            <td>Alimentación principal del módulo</td>
                        </tr>
                        <tr>
                            <td>GND</td>
                            <td>GND</td>
                            <td>Tierra común</td>
                        </tr>
                        <tr>
                            <td>IN1</td>
                            <td>Pin Digital 8</td>
                            <td>Señal de control de luz/relé</td>
                        </tr>
                        <tr>
                            <td rowspan="3"><strong>Sensor PIR (Movimiento)</strong></td>
                            <td>VCC</td>
                            <td>5V</td>
                            <td>Alimentación</td>
                        </tr>
                        <tr>
                            <td>GND</td>
                            <td>GND</td>
                            <td>Tierra</td>
                        </tr>
                        <tr>
                            <td>OUT</td>
                            <td>Pin Digital 2</td>
                            <td>Señal de detección de presencia</td>
                        </tr>
                        <tr>
                            <td rowspan="2"><strong>Fotorresistencia (LDR)</strong></td>
                            <td>Extremo 1</td>
                            <td>5V</td>
                            <td>Un extremo a 5V</td>
                        </tr>
                        <tr>
                            <td>Extremo 2</td>
                            <td>A0 (con R 10kΩ a GND)</td>
                            <td>Divisor de tensión para medir luminosidad</td>
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
                <pre class="mb-0"><code id="codigoArduino">// Definición de pines
const int pinPIR = 2;       // Pin de entrada del sensor PIR
const int pinRele = 8;      // Pin de salida para controlar el Relé
const int pinLDR = A0;      // Pin analógico de lectura de la fotorresistencia

// Umbral de oscuridad (0 a 1023)
const int umbralLuz = 400;  

void setup() {
  pinMode(pinPIR, INPUT);
  pinMode(pinRele, OUTPUT);
  
  // La mayoría de los módulos relé activan en LOW
  digitalWrite(pinRele, HIGH); // Relé apagado al inicio

  Serial.begin(9600);
  Serial.println("Sistema de Domotica Basica Inicializado.");
}

void loop() {
  int estadoPIR = digitalRead(pinPIR);
  int valorLuz = analogRead(pinLDR);

  Serial.print("Luz: ");
  Serial.print(valorLuz);
  Serial.print(" | Movimiento: ");
  Serial.println(estadoPIR == HIGH ? "DETECTADO" : "Sin movimiento");

  // Si hay poca luz Y se detecta movimiento, se enciende la luz (Relé)
  if (valorLuz < umbralLuz && estadoPIR == HIGH) {
    digitalWrite(pinRele, LOW);  // Enciende la carga (Relé ON)
    Serial.println("--> Luces Encendidas Automaticamente");
    delay(5000); // Mantiene encendida la luz por 5 segundos
  } else {
    digitalWrite(pinRele, HIGH); // Apaga la carga (Relé OFF)
  }

  delay(500);
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
                        <p>Colocá los componentes en el protoboard y realizá el cableado según la tabla de conexiones. Verificá cuidadosamente que las líneas de 5V y GND estén bien aisladas antes de conectar el USB.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>2. Carga del Código</h4>
                        <p>Abrí el entorno IDE de Arduino, conectá la placa al puerto USB de tu computadora, seleccioná la placa y el puerto COM correspondiente, y cargá el sketch del proyecto.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>3. Ajuste de Sensores</h4>
                        <p>Calibrá los potenciómetros del sensor PIR (sensibilidad y tiempo de retardo) y verificá la lectura de luz del LDR abriendo el Monitor Serie del IDE de Arduino.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>4. Prueba e Interacción</h4>
                        <p>Pasá la mano frente al PIR en condiciones de poca luz para comprobar que el relé active la luz automáticamente. Realizá los ajustes necesarios en el código para los umbrales de luz.</p>
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