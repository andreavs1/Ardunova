<?php


require_once __DIR__ . '/../../config/bootstrap.php';
require_once __DIR__ . '/../../config/database.php';

// Si el usuario ya está autenticado, redirigir al inicio
if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validaciones básicas
    if (empty($email)) {
        $errors[] = 'El correo electrónico es obligatorio.';
    }
    if (empty($password)) {
        $errors[] = 'La contraseña es obligatoria.';
    }

    if (empty($errors)) {
        // Consultar el usuario en la base de datos
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar la existencia del usuario y la contraseña
        if ($user && password_verify($password, $user['password'])) {
            // Regenerar ID de sesión para prevenir Session Fixation
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'] ?? '';

            header('Location: /index.php');
            exit;
        } else {
            $errors[] = 'Credenciales incorrectas.';
        }
    }
}

// Cargar la vista de login
require_once __DIR__ . '/../../views/auth/login.php';
