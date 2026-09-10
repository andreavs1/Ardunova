<?php

require_once __DIR__ . '/../../config/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /src/views/auth/login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    exit('El email y la contraseña son obligatorios.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('El email no es válido.');
}

try {

    // Buscar usuario por email
    $stmt = $pdo->prepare(
        'SELECT id, name, email, password
         FROM users
         WHERE email = :email
         LIMIT 1'
    );

    $stmt->execute([
        'email' => $email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar usuario y contraseña
    if (!$user || !password_verify($password, $user['password'])) {
        exit('Email o contraseña incorrectos.');
    }

    // Crear sesión
    session_regenerate_id(true);

    $_SESSION['user'] = [
        'id'    => $user['id'],
        'name'  => $user['name'],
        'email' => $user['email']
    ];

    // Ir al inicio
    header('Location: /src/views/index.php');
    exit;

} catch (PDOException $e) {

    exit('Ocurrió un error al iniciar sesión.');
}
?>