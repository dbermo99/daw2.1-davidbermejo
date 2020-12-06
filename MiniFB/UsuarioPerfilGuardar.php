<?php

require_once "_Varios.php";

$identificador= $_REQUEST["identificador"];
$contrasenna= $_REQUEST["contrasenna"];
$nombre= $_REQUEST["nombre"];
$apellidos= $_REQUEST["apellidos"];
$foto= $_REQUEST["foto"];

$correcto = actualizarUsuarioEnBD($identificador, $contrasenna, $nombre, $apellidos, $foto);

if ($correcto) {
    redireccionar("ContenidoPrivado1.php");
} else {
    redireccionar("ContenidoPrivado1.php");
}