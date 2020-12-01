<?php
require_once "_Varios.php";
session_start();
$_SESSION["identificador"] = $_REQUEST["identificador"];
$_SESSION["contrasenna"] = $_REQUEST["contrasenna"];

$arrayUsuario= obtenerUsuario($_SESSION["identificador"], $_SESSION["contrasenna"]);

if ($arrayUsuario) { // HAN venido datos: identificador existía y contraseña era correcta.
    marcarSesionComoIniciada($arrayUsuario);
    redireccionar("ContenidoPrivado1.php");
} else {
    redireccionar("SesionInicioMostrarFormulario.php");
}