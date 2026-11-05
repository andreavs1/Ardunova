<?php
session_start();
include __DIR__ . '/../conexion.php'; 

$id_proyecto_actual = 2;
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
    <meta name="description" content="Desplazamiento de textos y control de una pantalla LCD con Arduino.">
    <title>Pantalla LCD Dinámica - ARDUNOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="container section-container">
        <span class="tag-nivel intermedio">Intermedio</span>
        <h1 class="section-title">Pantalla LCD Dinámica</h1>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="project-info">
                    <h2>Explicación del Tutorial</h2>
                    <p>
                        Este tutorial enseña a utilizar e interconectar una pantalla alfanumérica LCD 16x2 (mediante el módulo de comunicación I2C) con un Arduino. Aprenderás a inicializar la pantalla, posicionar el cursor en filas y columnas específicas, mostrar caracteres personalizados y generar efectos visuales de desplazamiento lateral (scroll) de texto dinámico en tiempo real.
                    </p>
                    <h3>Objetivo</h3>
                    <p>Dominar la comunicación I2C con Arduino y la librería LiquidCrystal_I2C para desplegar información de manera dinámica y eficiente ocupando solo 2 pines de datos.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100">
                    <div class="card-image">
                        <img src="../assets/img/lcd-dinamica.jpg" alt="Pantalla LCD Dinámica" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN DEL SIMULADOR WOKWI -->
        <section class="mt-5">
            <h2 class="mb-3">Simulador Interactivo</h2>
            <p>Proba y modificá el código directamente desde el navegador antes de armar el circuito real.</p>
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="ratio ratio-16x9">
                    <iframe 
                        src="https://wokwi.com/projects/ID_DE_TU_PROYECTO_WOKWI/embed" 
                        title="Simulador de Arduino Pantalla LCD" 
                        allow="autoplay; camera; microphone" 
                        style="border: 0;">
                    </iframe>
                </div>
            </div>
        </section>

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
                        <h5>Pantalla / Display</h5>
                        <p class="mb-0">1x Pantalla LCD 16x2 con Módulo I2C PCF8574</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Conectividad</h5>
                        <p class="mb-0">4x Cables Jumper Macho-Hembra</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 border rounded bg-light h-100">
                        <h5>Alimentación</h5>
                        <p class="mb-0">1x Cable USB de programación para Arduino</p>
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
                            <th>Pin del Módulo I2C</th>
                            <th>Pin en Arduino UNO</th>
                            <th>Descripción / Función</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="4"><strong>Display LCD 16x2 (I2C)</strong></td>
                            <td>GND</td>
                            <td>GND</td>
                            <td>Tierra o polo negativo</td>
                        </tr>
                        <tr>
                            <td>VCC</td>
                            <td>5V</td>
                            <td>Alimentación principal (5V)</td>
                        </tr>
                        <tr>
                            <td>SDA</td>
                            <td>A4 (o pin SDA)</td>
                            <td>Línea de Datos del Bus I2C</td>
                        </tr>
                        <tr>
                            <td>SCL</td>
                            <td>A5 (o pin SCL)</td>
                            <td>Línea de Reloj del Bus I2C</td>
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
                <pre class="mb-0"><code id="codigoArduino">#include &lt;Wire.h&gt;
#include &lt;LiquidCrystal_I2C.h&gt;

// Inicializa el LCD en la dirección 0x27 (o 0x3F) para un display 16x2
LiquidCrystal_I2C lcd(0x27, 16, 2);

void setup() {
  lcd.init();          // Inicializa el LCD
  lcd.backlight();     // Enciende la luz de fondo

  // Mensaje de bienvenida
  lcd.setCursor(0, 0);
  lcd.print("PROYECTO ARDUNOVA");
  lcd.setCursor(0, 1);
  lcd.print("LCD DINAMICA");
  delay(2000);
  lcd.clear();
}

void loop() {
  // Mensaje estático en la primera línea
  lcd.setCursor(0, 0);
  lcd.print("   ARDUNOVA   ");

  // Texto desplazable en la segunda línea
  String texto = "  Bienvenidos al curso de Arduino y Domotica  ";
  
  for (int i = 0; i < texto.length() - 15; i++) {
    lcd.setCursor(0, 1);
    lcd.print(texto.substring(i, i + 16));
    delay(300); // Velocidad del desplazamiento
  }
  
  delay(1000);
}</code></pre>
            </div>
        </section>

        <!-- Descripción paso por paso -->
        <section class="mt-5">
            <h2 class="mb-4">Descripción Paso por Paso</h2>
            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>1. Conexión del Módulo</h4>
                        <p>Conectá el módulo I2C soldado al LCD hacia los pines correspondientes del Arduino (VCC a 5V, GND a GND, SDA a A4 y SCL a A5).</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>2. Instalación de Librería</h4>
                        <p>En el IDE de Arduino, andá a <em>Gestor de Librerías</em> y buscá e instalá <strong>LiquidCrystal_I2C</strong> por Frank de Brabander.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>3. Carga e Identificación</h4>
                        <p>Copiá el código anterior, pegalo en el IDE de Arduino y cargalo a la placa. Verificá la dirección I2C del display (habitualmente <code>0x27</code> o <code>0x3F</code>).</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="setup-step p-4 border rounded h-100">
                        <h4>4. Calibración de Contraste</h4>
                        <p>Si la pantalla se enciende pero no muestra texto, girá suavemente el potenciómetro azul ubicado detrás del módulo I2C con un destornillador hasta ver claramente las letras.</p>
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