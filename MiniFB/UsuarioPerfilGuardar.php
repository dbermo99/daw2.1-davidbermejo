<?php

require_once "_Varios.php";

$identificador= $_REQUEST["identificador"];
$contrasenna= $_REQUEST["contrasenna"];
$nombre= $_REQUEST["nombre"];
$apellidos= $_REQUEST["apellidos"];
if(isset($_FILES["foto"]["name"])) {
    $foto= $_FILES["foto"]["name"];
    $ruta= $_FILES["foto"]["tmp_name"];
    $destino= "fotos/".$foto;
    copy($ruta, $destino);
} else {
    $foto= null;
}


actualizarUsuarioEnBD($identificador, $contrasenna, $nombre, $apellidos, $foto);


redireccionar("ContenidoPrivado1.php");
