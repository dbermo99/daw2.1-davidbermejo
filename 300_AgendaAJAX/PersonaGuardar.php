<?php
	require_once "_com/Varios.php";
	require_once "_com/DAO.php";

	$id = (int)$_REQUEST["id"];
	$nombre = $_REQUEST["nombre"];
	$apellidos = $_REQUEST["apellidos"];
	$telefono = $_REQUEST["telefono"];
	$estrella = $_REQUEST["estrella"];
	$categoriaId = $_REQUEST["categoriaId"];

	$nuevaEntrada = ($id == -1);
	
	if ($nuevaEntrada) {
		 dao::personaCrear($nombre, $apellidos, $telefono, $estrella, $categoriaId);
	} else {
		dao::personaActualizar($id, $nombre, $apellidos, $telefono, $estrella, $categoriaId);
 	}
?>



<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php
	// Todo bien tanto si se han guardado los datos nuevos como si no se habían modificado.
	if ($correcto || $datosNoModificados) { ?>

		<?php if ($id == -1) { ?>
			<h1>Inserción completada</h1>
			<p>Se ha insertado correctamente la nueva entrada de <?php echo $nombre; ?>.</p>
		<?php } else { ?>
			<h1>Guardado completado</h1>
			<p>Se han guardado correctamente los datos de <?php echo $nombre; ?>.</p>

			<?php if ($datosNoModificados) { ?>
				<p>En realidad, no había modificado nada, pero no está de más que se haya asegurado pulsando el botón de guardar :)</p>
			<?php } ?>
		<?php }
?>

<?php
	} else {
?>

	<h1>Error en la modificación.</h1>
	<p>No se han podido guardar los datos de la persona.</p>

<?php
	}
?>

<a href='PersonaListado.php'>Volver al listado de personas.</a>

</body>

</html>