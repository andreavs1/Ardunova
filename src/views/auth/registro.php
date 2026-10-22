<?php
session_start();
include 'conexion.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nombre === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $error = 'Completá los datos correctamente. La contraseña debe tener al menos 8 caracteres.';
    } else {
        $stmt = $conn->prepare('SELECT id_usuarios FROM usuarios WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $existe = $stmt->get_result()->fetch_assoc();

        if ($existe) {
            $error = 'Ya existe una cuenta con ese correo electrónico.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)');
            $stmt->bind_param('sss', $nombre, $email, $hash);
            if ($stmt->execute()) {
                header('Location: login.php');
                exit();
            }
            $error = 'No se pudo registrar el usuario. Intentá nuevamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear cuenta - ARDUNOVA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css?v=20261020-5">
</head>
<body class="auth-body">
  <main class="auth-page-wrapper">
    <article class="auth-card">
      <img src="assets/img/logo.jpg" alt="Logo de ARDUNOVA" class="auth-logo">
      <h1 class="h2 text-center mb-4">Crear cuenta</h1>
      <?php if ($error): ?><div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
      <form method="POST" class="w-100">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre completo</label>
          <input id="nombre" type="text" name="nombre" class="form-control" placeholder="Tu nombre" required autocomplete="name">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Correo electrónico</label>
          <input id="email" type="email" name="email" class="form-control" placeholder="tu@email.com" required autocomplete="email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input id="password" type="password" name="password" class="form-control" placeholder="Mínimo 8 caracteres" required minlength="8" autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-gradient w-100 py-2 mt-2">Registrarse</button>
        <p class="auth-footer-text mb-0">¿Ya tenés una cuenta? <a href="login.php">Iniciá sesión</a></p>
      </form>
    </article>
  </main>
  <?php include 'includes/footer.php'; ?>
</body>
</html>
