<?php
// Permitir que el navegador envíe cookies y credenciales en localhost
header("Access-Control-Allow-Origin: http://localhost:8000");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json; charset=utf-8');

session_start();

ini_set('display_errors', 0);
error_reporting(E_ALL);

try {
    if (!isset($_SESSION['id_usuarios'])) {
        echo json_encode([
            'ok' => false,
            'mensaje' => 'No autorizado. Iniciá sesión de nuevo.'
        ]);
        exit();
    }

    include __DIR__ . '/conexion.php';

    if (!isset($conn) || !$conn) {
        throw new Exception('Error de conexión a la base de datos.');
    }

    $id_usuarios = $_SESSION['id_usuarios'];

    $input = json_decode(file_get_contents('php://input'), true);

    $id_tutorial = isset($input['id_tutorial'])
        ? intval($input['id_tutorial'])
        : (isset($_POST['id_tutorial']) ? intval($_POST['id_tutorial']) : 0);

    $id_proyecto = isset($input['id_proyecto'])
        ? intval($input['id_proyecto'])
        : (isset($_POST['id_proyecto']) ? intval($_POST['id_proyecto']) : 0);

    if ($id_tutorial > 0) {

        $stmt_progreso = $conn->prepare('
            INSERT INTO progreso (id_usuarios, id_tutorial, id_proyecto, completado)
            VALUES (?, ?, NULL, 1)
            ON DUPLICATE KEY UPDATE completado = 1
        ');

        if (!$stmt_progreso) {
            throw new Exception('Error al preparar la consulta: ' . $conn->error);
        }

        $stmt_progreso->bind_param('ii', $id_usuarios, $id_tutorial);

    } elseif ($id_proyecto > 0) {

        $stmt_progreso = $conn->prepare('
            INSERT INTO progreso (id_usuarios, id_tutorial, id_proyecto, completado)
            VALUES (?, NULL, ?, 1)
            ON DUPLICATE KEY UPDATE completado = 1
        ');

        if (!$stmt_progreso) {
            throw new Exception('Error al preparar la consulta: ' . $conn->error);
        }

        $stmt_progreso->bind_param('ii', $id_usuarios, $id_proyecto);

    } else {
        echo json_encode([
            'ok' => false,
            'mensaje' => 'ID de tutorial o proyecto inválido.'
        ]);
        exit();
    }

    if ($stmt_progreso->execute()) {
        echo json_encode(['ok' => true]);
    } else {
        throw new Exception('Error al guardar en la base de datos: ' . $stmt_progreso->error);
    }

    $stmt_progreso->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode([
        'ok' => false,
        'mensaje' => $e->getMessage()
    ]);
}