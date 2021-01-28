<?php

Require_once "_com/_Varios.php";
require_once "_com/dao.php";

/*$_SESSION["id"]= -1;
$_SESSION["identificador"]= "";
$_SESSION["nombre"]= "";
$_SESSION["apellidos"]= "";*/

dao::redireccionar("UsuarioPerfilVer.php?id=-1");

/*$identificador= $_REQUEST["identificador"];
$contrasenna= $_REQUEST["contrasenna"];
$nombre= $_REQUEST["nombre"];
$apellidos= $_REQUEST["apellidos"];

dao::usuarioCrear($identificador, $contrasenna, "", "", 0, $nombre, $apellidos);
$arrayUsuario = dao::obtenerUsuarioPorContrasenna($identificador, $contrasenna);


if ($arrayUsuario) {
    marcarSesionComoIniciada($arrayUsuario);
    redireccionar("ContenidoPrivado1.php");
} else {

}*/

