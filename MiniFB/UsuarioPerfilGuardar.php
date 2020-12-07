<?php

require_once "_Varios.php";

$identificador= $_REQUEST["identificador"];
$contrasenna= $_REQUEST["contrasenna"];
$nombre= $_REQUEST["nombre"];
$apellidos= $_REQUEST["apellidos"];
$foto= $_FILES["foto"]["name"];
$ruta= $_FILES["foto"]["tmp_name"];
$destino= "fotos/".$foto;
copy($ruta, $destino);

$correcto = actualizarUsuarioEnBD($identificador, $contrasenna, $nombre, $apellidos, $foto);

if ($correcto) {
    redireccionar("ContenidoPrivado1.php");
} else {
    redireccionar("ContenidoPrivado1.php");
}