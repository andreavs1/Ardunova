<?php
session_start();
if (!isset($_SESSION['usuario'])) { header('Location: login.php'); exit(); }
include __DIR__ . '/../config/conexion.php';

$nombre = $_SESSION['usuario'];

$stmt = $conn->prepare('SELECT id_usuarios, nombre, email FROM usuarios WHERE nombre = ? LIMIT 1');
$stmt->bind_param('s', $nombre);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();

if (!$usuario) { session_destroy(); header('Location: login.php'); exit(); }

$id_usuarios = $usuario['id_usuarios'];
$inicial = strtoupper(substr($usuario['nombre'], 0, 1));

$total_tutoriales = 0;
$total_proyectos = 0;
$tutoriales_completados_array = [];

// Obtener tutoriales completados por el usuario
$stmt_t = $conn->prepare('SELECT id_tutorial FROM progreso WHERE id_usuarios = ? AND id_tutorial IS NOT NULL AND completado = 1');
if ($stmt_t) {
    $stmt_t->bind_param('i', $id_usuarios);
    $stmt_t->execute();
    $res_t = $stmt_t->get_result();
    while ($row = $res_t->fetch_assoc()) {
        $tutoriales_completados_array[] = (int)$row['id_tutorial'];
    }
    $total_tutoriales = count($tutoriales_completados_array);
}

// Contar proyectos completados
$stmt_count_p = $conn->prepare('SELECT COUNT(*) AS total FROM progreso WHERE id_usuarios = ? AND id_proyecto IS NOT NULL AND completado = 1');
if ($stmt_count_p) {
    $stmt_count_p->bind_param('i', $id_usuarios);
    $stmt_count_p->execute();
    $total_proyectos = $stmt_count_p->get_result()->fetch_assoc()['total'] ?? 0;
}

// Cálculos de porcentajes y niveles
$total_tutoriales_sistema = 24;
$porcentaje_total = round(($total_tutoriales / $total_tutoriales_sistema) * 100);

// Nivel Principiante (Tutoriales 1 al 8)
$principiante_completados = count(array_intersect($tutoriales_completados_array, range(1, 8)));
$porcentaje_principiante = round(($principiante_completados / 8) * 100);

// Nivel Intermedio (Tutoriales 9 al 16)
$intermedio_completados = count(array_intersect($tutoriales_completados_array, range(9, 16)));
$porcentaje_intermedio = round(($intermedio_completados / 8) * 100);

// Nivel Avanzado (Tutoriales 17 al 24)
$avanzado_completados = count(array_intersect($tutoriales_completados_array, range(17, 24)));
$porcentaje_avanzado = round(($avanzado_completados / 8) * 100);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mi perfil - ARDUNOVA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/../assets/css/style.css?v=20261020-5">
</head>
<body>
<?php $active_page = ''; include __DIR__ . '../../../includes/header.php'; ?>
<main class="perfil-page container my-4">
  <section class="perfil-header mb-4">
    <div class="row align-items-center g-3">
      <div class="col-12 col-md-auto"><div class="perfil-avatar"><?= htmlspecialchars($inicial) ?></div></div>
      <div class="col-12 col-md">
        <div class="perfil-info">
          <h1 class="h2 mb-1"><?= htmlspecialchars($usuario['nombre']) ?></h1>
          <p class="mb-2 text-muted"><?= htmlspecialchars($usuario['email']) ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- TARJETAS DE RESUMEN Y BARRA DE PROGRESO GENERAL -->
  <section class="row g-3 mb-4">
    <div class="col-12 col-md-6">
      <div class="resumen-card bg-white p-4 rounded-4 shadow-sm h-100">
        <h3 class="h5 text-secondary">Proyectos</h3>
        <strong class="display-6"><?= $total_proyectos ?></strong>
        <p class="text-muted mb-0">Proyectos realizados</p>
      </div>
    </div>
    <div class="col-12 col-md-6">
      <div class="resumen-card bg-white p-4 rounded-4 shadow-sm h-100">
        <h3 class="h5 text-secondary">Tutoriales Completados</h3>
        <strong class="display-6"><?= $total_tutoriales ?> / <?= $total_tutoriales_sistema ?></strong>
        <div class="progress mt-2" style="height: 8px;">
          <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $porcentaje_total ?>%;"></div>
        </div>
        <small class="text-muted mt-1 d-block"><?= $porcentaje_total ?>% del curso total completado</small>
      </div>
    </div>
  </section>

  <!-- SECCIÓN DE PROGRESO POR NIVELES -->
  <section class="perfil-seccion mb-4 bg-white p-4 rounded-4 shadow-sm">
    <div class="seccion-titulo mb-3">
      <h2 class="h4 mb-0">Tu Progreso por Niveles</h2>
    </div>
    <div class="row g-3">
      <!-- Nivel Principiante -->
      <div class="col-md-12">
        <div class="p-3 border rounded-3 bg-light">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <h5 class="mb-0 fw-bold text-dark">🟢 Nivel Principiante</h5>
            <span class="badge bg-info text-dark"><?= $porcentaje_principiante ?>%</span>
          </div>
          <p class="small text-muted mb-2">Tutoriales del 1 al 8 (<?= $principiante_completados ?> de 8 completados)</p>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar bg-info" role="progressbar" style="width: <?= $porcentaje_principiante ?>%;"></div>
          </div>
        </div>
      </div>

      <!-- Nivel Intermedio -->
      <div class="col-md-12">
        <div class="p-3 border rounded-3 bg-light">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <h5 class="mb-0 fw-bold text-dark">🟡 Nivel Intermedio</h5>
            <span class="badge bg-warning text-dark"><?= $porcentaje_intermedio ?>%</span>
          </div>
          <p class="small text-muted mb-2">Tutoriales del 9 al 16 (<?= $intermedio_completados ?> de 8 completados)</p>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $porcentaje_intermedio ?>%;"></div>
          </div>
        </div>
      </div>

      <!-- Nivel Avanzado -->
      <div class="col-md-12">
        <div class="p-3 border rounded-3 bg-light">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <h5 class="mb-0 fw-bold text-dark">🔴 Nivel Avanzado</h5>
            <span class="badge bg-danger text-white"><?= $porcentaje_avanzado ?>%</span>
          </div>
          <p class="small text-muted mb-2">Tutoriales del 17 al 24 (<?= $avanzado_completados ?> de 8 completados)</p>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $porcentaje_avanzado ?>%;"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="perfil-seccion mb-4">
    <div class="seccion-titulo"><h2 class="h4 mb-0">Historial de Tutoriales</h2></div>
    <?php if ($total_tutoriales > 0): ?>
      <div class="alert alert-success mt-2">¡Felicitaciones! Has completado <?= $total_tutoriales ?> lección(es) en total.</div>
    <?php else: ?>
      <div class="historial-vacio mt-2 text-center p-5 bg-white rounded-4 shadow-sm">
        <h3>No hay tutoriales completados</h3>
        <p class="text-muted">Empezá tu primer tutorial para verlo reflejado en tu perfil.</p>
        <a href="../tutoriales/principiantes.php" class="btn btn-gradient">Explorar tutoriales</a>
      </div>
    <?php endif; ?>
  </section>

  <div class="text-center my-4"><a href="../logout.php" class="btn btn-outline-danger">Cerrar sesión</a></div>
</main>
<?php include __DIR__ . '../../../includes/chatbot.php'; ?>
<?php include __DIR__ . '../../../includes/footer.php'; ?>
</body>
</html>