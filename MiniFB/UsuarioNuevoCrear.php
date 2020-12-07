<?php
require_once "_Varios.php";

$identificador= $_REQUEST["identificador"];
$contrasenna= $_REQUEST["contrasenna"];
$nombre= $_REQUEST["nombre"];
$apellidos= $_REQUEST["apellidos"];
$foto= $_FILES["foto"]["name"];

// TODO Intentar crear (añadir funciones en _Varios.php para crear y tal).
//
// TODO Y redirigir a donde sea.

crearUsuario($identificador, $contrasenna, $nombre, $apellidos, $foto);
$arrayUsuario = obtenerUsuario($identificador, $contrasenna);

// TODO ¿Excepciones?

if ($arrayUsuario) {
    marcarSesionComoIniciada($arrayUsuario);
    redireccionar("ContenidoPrivado1.php");
} else {

}