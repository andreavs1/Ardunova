<?php
/*
 Logout se encarga de cerrar sesión y redirigirte a la página principal de ARDUNOVA
*/
session_start();
session_unset();
session_destroy();

header("Location: index.php");
exit();
?>
