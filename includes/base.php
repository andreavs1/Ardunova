<?php
// Calcula la ruta relativa a la raíz del sitio ($base) según la carpeta de la página actual.
// Raíz => ''   |   principiantes/, intermedio/, avanzado/, proyecto/ => '../'
if (!isset($base)) {
    $root = str_replace('\\', '/', realpath(__DIR__ . '/..'));
    $dir  = str_replace('\\', '/', realpath(dirname($_SERVER['SCRIPT_FILENAME'])));
    $rel  = trim(substr($dir, strlen($root)), '/');
    $base = ($rel === '') ? '' : str_repeat('../', substr_count($rel, '/') + 1);
}
