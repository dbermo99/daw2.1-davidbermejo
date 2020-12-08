<?php

require_once "_Varios.php";

$identificador= $_REQUEST["identificador"];
$contrasenna= $_REQUEST["contrasenna"];
$nombre= $_REQUEST["nombre"];
$apellidos= $_REQUEST["apellidos"];

if($_FILES["foto"]["name"] != null) {
    $foto= $_FILES["foto"]["name"];
    $ruta= $_FILES["foto"]["tmp_name"];
    $destino= "fotos/".$foto;
    copy($ruta, $destino);
} else {
    $pdo= obtenerPdoConexionBD();
    $sql= "SELECT foto FROM usuario WHERE id=$_SESSION[id]";
    $sentencia = $pdo->prepare($sql);
    $sentencia->execute([]);
    $rs = $sentencia->fetchAll();
    if($rs[0]["foto"] != null) {
        $foto= $rs[0]["foto"];
    }
}

actualizarUsuarioEnBD($identificador, $contrasenna, $nombre, $apellidos, $foto);


redireccionar("ContenidoPrivado1.php");
