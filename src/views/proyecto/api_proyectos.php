
<?php

require_once "conexion.php";

header("Content-Type: application/json; charset=UTF-8");

$sql = "SELECT 
            id_proyecto AS id,
            titulo,
            categoria_p AS nivel,
            descripcion,
            imagen,
            enlace
        FROM proyectos
        ORDER BY id_proyecto";

$resultado = $conn->query($sql);

$proyectos = [];

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $proyectos[] = $fila;
    }
}

echo json_encode($proyectos, JSON_UNESCAPED_UNICODE);

$conn->close();

?>
