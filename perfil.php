<?php
session_start();
if (!isset($_SESSION['usuario'])) { header('Location: login.php'); exit(); }
include 'conexion.php';

$nombre = $_SESSION['usuario'];

// Consultar datos del usuario (ya sin el campo rol)
$stmt = $conn->prepare('SELECT id_usuarios, nombre, email FROM usuarios WHERE nombre = ? LIMIT 1');
$stmt->bind_param('s', $nombre);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();

if (!$usuario) { session_destroy();
 header('Location: login.php'); exit(); }

$id_usuarios = $usuario['id_usuarios'];
$inicial = strtoupper(substr($usuario['nombre'], 0, 1));

// Contar cuántos tutoriales completó este usuario en la tabla progreso
$stmt_count = $conn->prepare('SELECT COUNT(*) AS total FROM progreso WHERE id_usuarios = ? AND completado = 1');
$stmt_count->bind_param('i', $id_usuarios);
$stmt_count->execute();
$resultado_count = $stmt_count->get_result()->fetch_assoc();
$total_tutoriales = $resultado_count['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mi perfil - ARDUNOVA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css?v=20261020-5">
</head>
<body>
<?php $active_page = ''; include 'includes/header.php'; ?>
<main class="perfil-page">
  <section class="perfil-header">
    <div class="row align-items-center g-3">
      <div class="col-12 col-md-auto"><div class="perfil-avatar"><?= htmlspecialchars($inicial) ?></div></div>
      <div class="col-12 col-md">
        <div class="perfil-info">
          <h1 class="h2 mb-1"><?= htmlspecialchars($usuario['nombre']) ?></h1>
          <p class="mb-2"><?= htmlspecialchars($usuario['email']) ?></p>
        </div>
      </div>
    </div>
  </section>

  <section class="row g-3 mb-4">
    <div class="col-12 col-md-6"><div class="resumen-card"><h3>Proyectos</h3><strong>0</strong><p>Proyectos realizados</p></div></div>
    <div class="col-12 col-md-6"><div class="resumen-card"><h3>Tutoriales</h3><strong><?= $total_tutoriales ?></strong><p>Tutoriales completados</p></div></div>
  </section>

  <section class="perfil-seccion">
    <div class="seccion-titulo d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
      <h2 class="h4 mb-0">Mi información</h2>
    </div>
    <div class="row g-3">
      <div class="col-12 col-md-6"><div class="informacion-item"><span>Nombre</span><strong><?= htmlspecialchars($usuario['nombre']) ?></strong></div></div>
      <div class="col-12 col-md-6"><div class="informacion-item"><span>Correo electrónico</span><strong><?= htmlspecialchars($usuario['email']) ?></strong></div></div>
    </div>
  </section>

  <section class="perfil-seccion">
    <div class="seccion-titulo d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
      <h2 class="h4 mb-0">Historial de proyectos</h2><a href="proyectos.php">Ver proyectos</a>
    </div>
    <div class="historial-vacio"><h3>Todavía no realizaste proyectos</h3><p>Cuando realices un proyecto, aparecerá acá.</p><a href="proyectos.php" class="btn btn-gradient">Explorar proyectos</a></div>
  </section>

  <section class="perfil-seccion">
    <div class="seccion-titulo"><h2 class="h4 mb-0">Tutoriales completados</h2></div>
    <?php if ($total_tutoriales > 0): ?>
      <div class="alert alert-success">¡Felicitaciones! Has completado <?= $total_tutoriales ?> lección(es).</div>
    <?php else: ?>
      <div class="historial-vacio"><h3>No hay tutoriales completados</h3><p>Empezá un tutorial para verlo en tu historial.</p><a href="tutoriales.php" class="btn btn-gradient">Explorar tutoriales</a></div>
    <?php endif; ?>
  </section>

  <div class="text-center my-4"><a href="logout.php" class="btn btn-outline-cyan">Cerrar sesión</a></div>
</main>
<?php include 'includes/chatbot.php'; ?>
<?php include 'includes/footer.php'; ?>
</body>
</html>
