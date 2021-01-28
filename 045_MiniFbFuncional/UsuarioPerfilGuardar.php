<?php

require_once "_com/_Varios.php";
require_once "_com/dao.php";

$id= $_SESSION["id"];
$identificador= $_REQUEST["identificador"];
$contrasenna= $_REQUEST["contrasenna"];
$nombre= $_REQUEST["nombre"];
$apellidos= $_REQUEST["apellidos"];

$_SESSION["identificador"] = $identificador;
$_SESSION["nombre"] = $nombre;
$_SESSION["apellidos"] = $apellidos;

if(!haySesionRamIniciada() || $_SESSION["id"] == -1) {
    $correcto= dao::usuarioCrear($identificador, $contrasenna, "", "", 0, $nombre, $apellidos);
    dao::redireccionar("SesionInicioComprobar.php?identificador=".$identificador."&contrasenna=".$contrasenna);
}else {
    $correcto= dao::usuarioGuardarPorId($id, $identificador, $contrasenna, "", "", 0, $nombre, $apellidos);
}

if ($correcto) {
    dao::redireccionar("MuroVerGlobal.php");
} else {
    dao::redireccionar("UsuarioPerfilVer.php?error");
}