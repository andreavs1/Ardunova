<?php
header('Content-Type: application/json; charset=utf-8');
include '../conexion.php'; // Conexión MySQLi con $conn

$id_tutorial = isset($_GET['id']) ? intval($_GET['id']) : 17;

try {
    // 1. Obtener datos principales del tutorial
    $sql = "SELECT * FROM tutoriales WHERE id_tutorial = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_tutorial);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $tutorial = $resultado->fetch_assoc();

    if (!$tutorial) {
        http_response_code(404);
        echo json_encode(["error" => "Tutorial no encontrado"]);
        exit;
    }

    // 2. Obtener funciones clave asociadas
    $sqlFunc = "SELECT icono, titulo, descripcion, detalle FROM tutorial_funciones WHERE id_tutorial = ?";
    $stmtFunc = $conn->prepare($sqlFunc);
    $stmtFunc->bind_param("i", $id_tutorial);
    $stmtFunc->execute();
    $resFunc = $stmtFunc->get_result();
    $funciones = [];
    while ($row = $resFunc->fetch_assoc()) {
        $funciones[] = $row;
    }

    // 3. Obtener opciones del quiz asociadas
    $sqlQuiz = "SELECT texto_opcion AS texto, es_correcta FROM tutorial_quiz_opciones WHERE id_tutorial = ?";
    $stmtQuiz = $conn->prepare($sqlQuiz);
    $stmtQuiz->bind_param("i", $id_tutorial);
    $stmtQuiz->execute();
    $resQuiz = $stmtQuiz->get_result();
    $quiz_opciones = [];
    while ($row = $resQuiz->fetch_assoc()) {
        $row['es_correcta'] = (bool)$row['es_correcta'];
        $quiz_opciones[] = $row;
    }

    // 4. Armar la estructura exacta que espera tu JS de avanzado
    $dataFormatted = [
        "badge" => $tutorial['badge'],
        "titulo" => $tutorial['titulo'],
        "subtitulo" => $tutorial['subtitulo'],
        "concepto_principal" => [
            "titulo" => $tutorial['concepto_titulo'],
            "descripcion" => $tutorial['concepto_descripcion']
        ],
        "funciones_clave" => $funciones,
        "codigo_ejemplo" => [
            "titulo" => $tutorial['codigo_titulo'],
            "lenguaje" => $tutorial['codigo_lenguaje'],
            "codigo" => $tutorial['codigo_fuente']
        ],
        "quiz" => [
            "pregunta" => $tutorial['quiz_pregunta'],
            "opciones" => $quiz_opciones,
            "mensaje_correcto" => $tutorial['quiz_mensaje_correcto'],
            "mensaje_incorrecto" => $tutorial['quiz_mensaje_incorrecto']
        ]
    ];

    echo json_encode($dataFormatted, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>