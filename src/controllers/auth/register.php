<?php

require_once __DIR__ . '/../../config/bootstrap.php';
require_once __DIR__ . '/../../config/database.php';

// Si el usuario ya inició sesión, redirigir al inicio
if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

$errors = [];
$old = [
    'name' => '',
    'email' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    $old['name'] = $name;
    $old['email'] = $email;

    // Validaciones de entrada
    if (empty($name)) {
        $errors[] = 'El nombre es obligatorio.';
    }

    if (empty($email)) {
        $errors[] = 'El correo electrónico es obligatorio.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'El correo electrónico no es válido.';
    }

    if (empty($password)) {
        $errors[] = 'La contraseña es obligatoria.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
    }

    if ($password !== $confirm_password) {
        $errors[] = 'Las contraseñas no coinciden.';
    }

    // Comprobar que el email no esté registrado previamente
    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $errors[] = 'El correo electrónico ya está registrado.';
        }
    }

    // Registrar al usuario si no hay errores
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $success = $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);

        if ($success) {
            $_SESSION['flash_success'] = 'Registro exitoso. Ya puedes iniciar sesión.';
            header('Location: /src/controllers/auth/login.php');
            exit;
        } else {
            $errors[] = 'Ocurrió un error al registrar el usuario. Inténtalo de nuevo.';
        }
    }
}

require_once __DIR__ . '/../../views/auth/register.php';