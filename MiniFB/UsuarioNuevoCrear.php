<?php
require_once "_Varios.php";

$identificador= $_REQUEST["identificador"];
$contrasenna= $_REQUEST["contrasenna"];
$nombre= $_REQUEST["nombre"];
$apellidos= $_REQUEST["apellidos"];

// TODO Intentar crear (añadir funciones en _Varios.php para crear y tal).
//
// TODO Y redirigir a donde sea.

$arrayUsuario = crearUsuario($identificador, $contrasenna, $nombre, $apellidos);

// TODO ¿Excepciones?

/*if ($arrayUsuario) {

} else {

}*/