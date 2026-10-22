<?php
session_start();
include 'conexion.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare('SELECT nombre, email, password FROM usuarios WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario'] = $usuario['nombre'];
        header('Location: index.php');
        exit();
    }
    $error = 'El correo o la contraseña no son correctos.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar sesión - ARDUNOVA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css?v=20261020-5">
</head>
<body class="auth-body">
  <main class="auth-page-wrapper">
    <article class="auth-card">
      <img src="assets/img/logo.jpg" alt="Logo de ARDUNOVA" class="auth-logo">
      <h1 class="h2 text-center mb-4">Iniciar sesión</h1>
      <?php if ($error): ?><div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
      <form method="POST" class="w-100" novalidate>
        <div class="mb-3">
          <label for="email" class="form-label">Correo electrónico</label>
          <input id="email" type="email" name="email" class="form-control" placeholder="tu@email.com" required autocomplete="email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input id="password" type="password" name="password" class="form-control" placeholder="Tu contraseña" required autocomplete="current-password">
        </div>
        <button type="submit" class="btn btn-gradient w-100 py-2 mt-2">Ingresar</button>
        <p class="auth-footer-text mb-0">¿No tenés cuenta? <a href="registro.php">Registrate</a></p>
      </form>
    </article>
  </main>
  <?php include 'includes/footer.php'; ?>
</body>
</html>
