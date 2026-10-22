<?php session_start(); $active_page='proyectos'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Proyecto: Parpadeo de LED - ARDUNOVA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>
<main class="container section-container">
  <div class="project-header">
    <span class="tag-nivel principiante">Principiante</span>
    <h1 class="section-title mb-2">Parpadeo de LED (Blink)</h1>
    <p class="section-subtitle">El clásico "Hola Mundo" del hardware libre.</p>
  </div>

  <div class="row g-4">
    <div class="col-12 col-lg-7"><div class="project-info"><h2>Explicación</h2>
    <p>Este proyecto sirve para aprender a controlar una salida digital de Arduino. El LED se enciende y se apaga automáticamente cada segundo.</p><h3>Materiales</h3><ul><li>Arduino UNO</li><li>LED</li><li>Resistencia de 220Ω</li><li>Protoboard</li><li>Cables</li></ul></div></div>
    <div class="col-12 col-lg-5">
      <div class="card h-100"><div class="card-image">
        <img src="<?= BASE_URL ?>assets/img/lcd.jpg" alt="Componentes del proyecto LED"></div></div></div>
  </div>
  <section class="code-section mt-5">
    <h2>Código</h2>
    <div class="card code-card">
      <pre>
        <code>
          void setup() {
  pinMode(13, OUTPUT);
}

void loop() {
  digitalWrite(13, HIGH);
  delay(1000);
  digitalWrite(13, LOW);
  delay(1000);
}</code></pre></div></section>
  <section class="steps-section mt-5"><h2 class="mb-4">Paso a paso</h2>
  <div class="row g-3">
    <div class="col-12 col-md-4"><div class="setup-step p-4">
      <h4>Conexiones</h4>
      <p>Conectá la pata larga del LED al pin 13 y la corta a GND mediante una resistencia.</p>
    </div></div>
    <div class="col-12 col-md-4"><div class="setup-step p-4">
      <h4>Software</h4>
      <p>Abrí Arduino IDE, copiá el código y seleccioná la placa Arduino UNO.</p>
    </div>
  </div>
    <div class="col-12 col-md-4"><div class="setup-step p-4">
      <h4>Carga</h4>
      <p>Cargá el programa y observá cómo el LED se prende y apaga.</p>
    </div>
  </div>
  </div>
  <div class="result-card">
    <h4>Resultado esperado</h4>
    <p class="mb-0">El LED se prenderá y apagará cada segundo de forma continua.</p>
  </div>
  <div class="text-center button-container">
    <a href="<?= BASE_URL ?>proyecto/proyectos.php" class="btn btn-outline-cyan">← Volver a Proyectos</a>
</div></section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body></html>
