<?php
session_start();

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__. '/../../config/conexion.php';

$id_tutorial = isset($_GET['id']) ? intval($_GET['id']) : 1;

try {

    // Obtener datos principales del tutorial
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

    // Consultar si el usuario completó el tutorial
    $completado = false;

    if (isset($_SESSION['id_usuarios'])) {

        $id_usuario = $_SESSION['id_usuarios'];

        $sqlProgreso = "SELECT completado FROM progreso
                        WHERE id_usuarios = ? AND id_tutorial = ?";

        $stmtProgreso = $conn->prepare($sqlProgreso);
        $stmtProgreso->bind_param("ii", $id_usuario, $id_tutorial);
        $stmtProgreso->execute();

        $resultadoProgreso = $stmtProgreso->get_result();

        if ($fila = $resultadoProgreso->fetch_assoc()) {
            $completado = (bool)$fila['completado'];
        }
    }

    // Obtener funciones clave
    $sqlFunc = "SELECT icono, titulo, descripcion, detalle
                FROM tutorial_funciones
                WHERE id_tutorial = ?";

    $stmtFunc = $conn->prepare($sqlFunc);
    $stmtFunc->bind_param("i", $id_tutorial);
    $stmtFunc->execute();

    $resFunc = $stmtFunc->get_result();
    $funciones = [];

    while ($row = $resFunc->fetch_assoc()) {
        $funciones[] = $row;
    }

    // Obtener opciones del cuestionario
    $sqlQuiz = "SELECT texto_opcion AS texto, es_correcta
                FROM tutorial_quiz_opciones
                WHERE id_tutorial = ?";

    $stmtQuiz = $conn->prepare($sqlQuiz);
    $stmtQuiz->bind_param("i", $id_tutorial);
    $stmtQuiz->execute();

    $resQuiz = $stmtQuiz->get_result();
    $quiz_opciones = [];

    while ($row = $resQuiz->fetch_assoc()) {
        $row['es_correcta'] = (bool)$row['es_correcta'];
        $quiz_opciones[] = $row;
    }

    // Preparar datos para JavaScript
    $dataFormatted = [
        "completado" => $completado,
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

        "simulador_wokwi" => !empty($tutorial['wokwi_project_id']) ? [
            "titulo" => $tutorial['wokwi_titulo'] ?? "Simulador Interactivo",
            "project_id" => $tutorial['wokwi_project_id'],
            "instruccion" => $tutorial['wokwi_instruccion'] ?? "",
            "nota" => $tutorial['wokwi_nota'] ?? ""
        ] : null,

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
