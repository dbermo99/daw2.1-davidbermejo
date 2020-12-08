<?php
require_once "_Varios.php";

$identificador= $_REQUEST["identificador"];
$contrasenna= $_REQUEST["contrasenna"];
$nombre= $_REQUEST["nombre"];
$apellidos= $_REQUEST["apellidos"];
$foto= $_FILES["foto"]["name"];

crearUsuario($identificador, $contrasenna, $nombre, $apellidos, $foto);
$arrayUsuario = obtenerUsuario($identificador, $contrasenna);

if ($arrayUsuario) {
    marcarSesionComoIniciada($arrayUsuario);
    redireccionar("ContenidoPrivado1.php");
} else {

}