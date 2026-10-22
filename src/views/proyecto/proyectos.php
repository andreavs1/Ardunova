<?php
session_start();
$active_page = 'proyectos';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="ARDUNOVA - Aprendizaje práctico de Arduino, electrónica y robótica.">

  <title>Proyectos Prácticos - ARDUNOVA</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>

<?php include '../includes/header.php'; ?>

<main class="container section-container">

  <div class="page-heading">
    <span class="section-kicker">Catálogo de proyectos</span>
    <h1 class="section-title">Proyectos prácticos</h1>
    <p>Filtrá por nivel y encontrá el próximo circuito que querés construir.</p>
  </div>

  <div class="filtros">

    <label for="filtro-nivel">Filtrar por nivel:</label>

    <select id="filtro-nivel" class="filtro-select">
      <option value="todos">Todos</option>
      <option value="principiante">Principiante</option>
      <option value="intermedio">Intermedio</option>
      <option value="avanzado">Avanzado</option>
    </select>

  </div>


  <div class="row g-4" id="lista-proyectos"></div>
   
</main>


<?php include '../includes/chatbot.php'; ?>

<?php include '../includes/footer.php'; ?>



<script src="proyectos.js"></script>

</body>
</html>
