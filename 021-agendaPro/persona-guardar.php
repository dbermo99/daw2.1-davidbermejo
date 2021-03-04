<?php
	require_once "_varios.php";

	$pdo = obtenerPdoConexionBD();

	$id = (int)$_REQUEST["id"];
	$estrella = isset($_REQUEST["estrella"]);
	$nombre = $_REQUEST["nombre"];
	$apellido= $_REQUEST["apellido"];
	$telefono= $_REQUEST["telefono"];
	$personaCategoriaId= $_REQUEST["categoriaId"];

	$nuevaEntrada = ($id == -1);
	
	if ($nuevaEntrada) {
 		$sql = "INSERT INTO persona (estrella, nombre, apellido, telefono, categoria_id) VALUES (?, ?, ?, ?)";
 		$parametros = [$estrella, $nombre, $apellido, $telefono, $personaCategoriaId];
	} else {
 		$sql = "UPDATE persona SET estrella=?, nombre=?, apellido=?, telefono=?, categoria_id=? WHERE id=?";
        $parametros = [$estrella?1:0, $nombre, $apellido, $telefono, $personaCategoriaId, $id];
 	}
 	
    $sentencia = $pdo->prepare($sql);
    $sql_con_exito = $sentencia->execute($parametros);

 	$una_fila_afectada = ($sentencia->rowCount() == 1);
 	$ninguna_fila_afectada = ($sentencia->rowCount() == 0);

 	$correcto = ($sql_con_exito && $una_fila_afectada);

 	$datos_no_modificados = ($sql_con_exito && $ninguna_fila_afectada);
?>



<html>

<head>
	<meta charset="UTF-8">
</head>



<body>

<?php
	if ($correcto || $datos_no_modificados) { ?>

		<?php if ($id == -1) { ?>
			<h1>Inserción completada</h1>
			<p>Se ha insertado correctamente la nueva entrada de <?php echo $nombre; ?>.</p>
		<?php } else { ?>
			<h1>Guardado completado</h1>
			<p>Se han guardado correctamente los datos de <?php echo $nombre; ?>.</p>

			<?php if ($datos_no_modificados) { ?>
				<p>No ha habido ninguna modificacion.</p>
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

<a href="persona-listado.php">Volver al listado de persona.</a>

</body>

</html>