<?php
require_once "_Varios.php";

$_SESSION["identificador"] = $_REQUEST["identificador"];
$_SESSION["contrasenna"] = $_REQUEST["contrasenna"];

$arrayUsuario= obtenerUsuario($_SESSION["identificador"], $_SESSION["contrasenna"]);

if ($arrayUsuario) {
    marcarSesionComoIniciada($arrayUsuario);

    if(isset($_REQUEST["recordar"])) {
        generarCookieRecordar($arrayUsuario);
    }

    redireccionar("ContenidoPrivado1.php");
} else {
    redireccionar("SesionInicioMostrarFormulario.php?incorrecto");
}