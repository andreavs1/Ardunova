<?php

require_once __DIR__ . '/../../config/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /src/views/auth/register.php');
    exit;
}

$data = [
    'email'          => trim($_POST['email'] ?? ''),
    'name'           => trim($_POST['name'] ?? ''),
    'password'       => $_POST['password'] ?? '',
      'repeatPassword' => $_POST['repeatPassword'] ?? ''
];

if (
    $data['name'] === '' ||
    $data['email'] === '' ||
    $data['password'] === '' ||
    $data['repeatPassword'] === ''
) {
    exit('Todos los campos son obligatorios.');
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    exit('El email no es válido.');
}

if ($data['password'] !== $data['repeatPassword']) {
    exit('Las contraseñas no coinciden.');
}

if (strlen($data['password']) < 6) {
    exit('La contraseña debe tener al menos 6 caracteres.');
}

try {

    // Verificar si el usuario ya existe
    $stmt = $pdo->prepare(
        'SELECT id FROM users WHERE email = :email LIMIT 1'
    );

    $stmt->execute([
        'email' => $data['email']
    ]);

    if ($stmt->fetch()) {
        exit('Ese email ya está registrado.');
    }

    // Encriptar contraseña
    $hashedPassword = password_hash(
        $data['password'],
        PASSWORD_DEFAULT
      );

    // Crear usuario
    $stmt = $pdo->prepare(
        'INSERT INTO users (name, email, password)
         VALUES (:name, :email, :password)'
    );

    $stmt->execute([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => $hashedPassword
    ]);

    // Obtener el usuario creado
    $stmt = $pdo->prepare(
        'SELECT id, name, email
         FROM users
         WHERE email = :email
         LIMIT 1'
    );

    $stmt->execute([
        'email' => $data['email']
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Guardar usuario en sesión
    $_SESSION['user'] = [
        'id'    => $user['id'],
        'name'  => $user['name'],
        'email' => $user['email']
    ];

    header('Location: /src/views/index.php');
    exit;

} catch (PDOException $e) {

    exit('Ocurrió un error al crear la cuenta.');
}
?>