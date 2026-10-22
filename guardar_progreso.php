<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// No mostrar errores HTML de PHP (rompen la respuesta JSON)
ini_set('display_errors', 0);
error_reporting(E_ALL);

try {
    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuario'])) {
        echo json_encode(['ok' => false, 'mensaje' => 'No autorizado. Iniciá sesión de nuevo.']);
        exit();
    }

    include __DIR__ . '/conexion.php';
    if (!isset($conn) || !$conn) {
        throw new Exception('Error de conexión a la base de datos.');
    }

    $nombre_usuario = $_SESSION['usuario'];
    $stmt_user = $conn->prepare('SELECT id_usuarios FROM usuarios WHERE nombre = ? LIMIT 1');
    $stmt_user->bind_param('s', $nombre_usuario);
    $stmt_user->execute();
    $resultado_user = $stmt_user->get_result();

    if ($resultado_user->num_rows === 0) {
        echo json_encode(['ok' => false, 'mensaje' => 'Usuario no encontrado en la base de datos.']);
        exit();
    }

    $id_usuarios = $resultado_user->fetch_assoc()['id_usuarios'];
    $id_tutorial = isset($_POST['id_tutorial']) ? intval($_POST['id_tutorial']) : 0;

    if ($id_tutorial <= 0) {
        echo json_encode(['ok' => false, 'mensaje' => 'ID de tutorial inválido.']);
        exit();
    }

    // Insertar o actualizar el progreso
    $stmt_progreso = $conn->prepare('
        INSERT INTO progreso (id_usuarios, id_tutorial, completado)
        VALUES (?, ?, 1)
        ON DUPLICATE KEY UPDATE completado = 1
    ');

    if (!$stmt_progreso) {
        throw new Exception('Error al preparar la consulta: ' . $conn->error);
    }

    $stmt_progreso->bind_param('ii', $id_usuarios, $id_tutorial);

    if ($stmt_progreso->execute()) {
        echo json_encode(['ok' => true]);
    } else {
        throw new Exception('Error al guardar en la base de datos: ' . $stmt_progreso->error);
    }

} catch (Exception $e) {
    echo json_encode(['ok' => false, 'mensaje' => $e->getMessage()]);
}
