<?php session_start(); $active_page = 'proyectos'; ?>
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
                    <h2>Sobre el proyecto</h2>
                    <p>Desplazamiento de textos y control de una pantalla LCD con Arduino.</p>
                    <h3>Objetivo</h3>
                    <p>Comprender cómo conectar los componentes, programar la placa y comprobar el funcionamiento paso a paso.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100">
                    <div class="card-image">
                        <img src="<?= BASE_URL ?>assets/img/lcd-dinamica.jpg" alt="Pantalla LCD Dinámica">
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

        <section class="mt-5">
            <h2 class="mb-4">Pasos básicos</h2>
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="setup-step p-4">
                        <h4>1. Preparar</h4>
                        <p>Reuní los componentes y verificá las conexiones antes de alimentar el circuito.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="setup-step p-4">
                        <h4>2. Programar</h4>
                        <p>Cargá el sketch correspondiente y comprobá que la placa sea la correcta.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="setup-step p-4">
                        <h4>3. Probar</h4>
                        <p>Ejecutá el proyecto y ajustá las conexiones o parámetros si fuera necesario.</p>
                    </div>
                </div>
            </div>
        </section>
        <div class="text-center button-container my-4">
            <a href="<?= BASE_URL ?>proyecto/proyectos.php" class="btn btn-outline-cyan">← Volver a Proyectos</a>
        </div>
    </main>
    
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>