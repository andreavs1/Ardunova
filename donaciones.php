<?php
session_start();
$active_page = 'donaciones';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Colaborá con ARDUNOVA y ayudanos a acercar la tecnología, Arduino y la robótica a más estudiantes.">

    <title>Donaciones - ARDUNOVA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20261020-5">
</head>

<body>

<?php include 'includes/header.php'; ?>

<main class="container section-container py-4">

    <!-- Encabezado -->
    <section class="page-heading text-center mb-5">
        <span class="section-kicker">Sumate a nuestra misión</span>

        <h1 class="section-title mb-3">
            Ayudanos a construir el futuro
        </h1>

        <p class="lead mb-0 mx-auto page-intro">
            En ARDUNOVA creemos que la tecnología debe estar al alcance
            de todos. Tu colaboración puede ayudarnos a crear más recursos
            educativos y acercar el mundo de Arduino a nuevos estudiantes.
        </p>
    </section>

    <!-- Por qué colaborar -->
    <section class="mb-5">
        <h2 class="text-center mb-4">¿Por qué colaborar con ARDUNOVA?</h2>

        <div class="row g-4 justify-content-center">

            <div class="col-12 col-md-6 col-lg-4">
                <article class="card h-100">
                    <div class="card-body text-center">
                        <div class="team-initial">01</div>

                        <h3 class="mb-3">Educación accesible</h3>

                        <p>
                            Nos ayudás a seguir compartiendo tutoriales,
                            guías y materiales para que más estudiantes
                            puedan aprender tecnología.
                        </p>
                    </div>
                </article>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <article class="card h-100">
                    <div class="card-body text-center">
                        <div class="team-initial">02</div>

                        <h3 class="mb-3">Proyectos prácticos</h3>

                        <p>
                            Tu aporte puede contribuir a conseguir
                            componentes electrónicos y materiales para
                            realizar prácticas de Arduino y robótica.
                        </p>
                    </div>
                </article>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <article class="card h-100">
                    <div class="card-body text-center">
                        <div class="team-initial">03</div>

                        <h3 class="mb-3">Innovación abierta</h3>

                        <p>
                            Nos ayudás a fomentar la creatividad,
                            el aprendizaje colaborativo y el desarrollo
                            de soluciones tecnológicas.
                        </p>
                    </div>
                </article>
            </div>

        </div>
    </section>

    <!-- Destino de las donaciones -->
    <section class="mb-5">
        <h2 class="text-center mb-4">¿A qué se destinarían los aportes?</h2>

        <div class="row g-4 justify-content-center">

            <div class="col-12 col-md-6">
                <article class="card h-100">
                    <div class="card-body">
                        <h3 class="mb-3">Materiales electrónicos</h3>

                        <p class="mb-0">
                            Componentes como placas Arduino, sensores,
                            cables, protoboards y otros elementos
                            necesarios para experimentar y aprender.
                        </p>
                    </div>
                </article>
            </div>

            <div class="col-12 col-md-6">
                <article class="card h-100">
                    <div class="card-body">
                        <h3 class="mb-3">Recursos educativos</h3>

                        <p class="mb-0">
                            Desarrollo y mejora de tutoriales, ejemplos
                            de programación, esquemas de circuitos y
                            materiales de consulta para estudiantes.
                        </p>
                    </div>
                </article>
            </div>

        </div>

        <p class="text-center text-muted small mt-3">
            Estos son los posibles destinos de los aportes.
            Su implementación dependerá de los recursos disponibles
            y de las necesidades del proyecto.
        </p>
    </section>

    <!-- Cómo colaborar -->
    <section class="mb-5">
        <article class="card">
            <div class="card-body text-center p-4">

                <span class="section-kicker">Cada aporte cuenta</span>

                <h2 class="mb-3">¿Querés colaborar con ARDUNOVA?</h2>

                <p class="mx-auto page-intro mb-4">
                    Estamos trabajando para habilitar un medio de
                    colaboración seguro. Próximamente vas a poder
                    conocer las opciones disponibles para apoyar
                    nuestro proyecto educativo.
                </p>

                <button
                    type="button"
                    class="btn btn-primary"
                    disabled
                >
                    Donaciones próximamente
                </button>

                <p class="text-muted small mt-3 mb-0">
                    Actualmente, esta sección es informativa.
                    Todavía no se reciben pagos desde esta página.
                </p>

            </div>
        </article>
    </section>

</main>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
