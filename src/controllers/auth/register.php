<?php
require_once __DIR__ . '/../../config/bootstrap.php';

// Paso clave #1: Validar tipo de solicitud ----------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {  // Si la solicitud no es POST, volves al register
  header('Location: /src/views/auth/register.php');
  exit;
}

// Paso clave #2: Tomar datos -----------------------------------
$data = [
  'email'           => trim($_POST['email'] ?? ''), // trim(str) saca los espacios al inicio y al final
  'name'            => trim($_POST['name'] ?? ''),
  'password'        => $_POST['password'] ?? '',
  'repeatPassword'  => $_POST['password'] ?? ''
];

// Validaciones básicas
if (
  empty($data['email']) ||
  empty($data['name']) ||
  empty($data['password']) ||
  empty($data['repeatPassword'])
) {
  header('Location: /src/views/auth/register.php?error=empty');
  exit;
}

// Validar que las contraseñas coincidan
if ($data['password'] !== $data['repeatPassword']) {
  header('Location: /src/views/auth/register.php?error=nomatch');
  exit;
}

try {

  // Verificar si el usuario ya existe
  $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
  $stmt->execute(['email' => $data['email']]);

  if ($stmt->fetch()) {
    header('Location: /src/views/auth/register.php?error=exists');
    exit;
  }

  // Hashear contraseña
  $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

  // Insertar usuario
  $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
  $stmt->execute([
    'name' => $data['name'],
    'email' => $data['email'],
    'password' => $hashedPassword,
  ]);

  // Crear sesión
  $_SESSION['user'] = [
    'id' => $pdo->lastInsertId(),
    'name' => $data['name'],
    'email' => $data['email'],
  ];

  // Pateado para el index
  header('Location: /src/views/index.php');
  exit;
} catch (PDOException $e) {
  exit;
}
