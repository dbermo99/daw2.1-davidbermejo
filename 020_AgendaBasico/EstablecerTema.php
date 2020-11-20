<?php
    require_once "_varios.php";
    session_start();
    $pdo = obtenerPdoConexionBD();
    $id = (int)$_REQUEST["id"];
    $ficha = $_REQUEST["ficha"];
    if($_SESSION["tema"] == "Claro") {
        $_SESSION["tema"] = "Oscuro";
    } else if($_SESSION["tema"] == "Oscuro") {
        $_SESSION["tema"] = "Claro";
    }
    redireccionar($ficha);
?>