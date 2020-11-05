<?php
	require_once "_varios.php";

	$pdo = obtenerPdoConexionBD();

	$id = (int)$_REQUEST["id"];

	$sql = "DELETE FROM persona WHERE id=?";

    $sentencia = $pdo->prepare($sql);
    $sql_con_exito = $sentencia->execute([$id]);

    $una_fila_afectada = ($sentencia->rowCount() == 1);
    $ninguna_fila_afectada = ($sentencia->rowCount() == 0);

    $correcto = ($sql_con_exito && $una_fila_afectada);

 	$no_existia = ($sql_con_exito && $ninguna_fila_afectada);
?>



<html>

<head>
	<meta charset="UTF-8">
</head>



<body>

<?php if ($correcto) { ?>

	<h1>Eliminación completada</h1>
	<p>Se ha eliminado correctamente la persona.</p>

<?php } else if ($no_existia) { ?>

	<h1>Eliminación imposible</h1>
	<p>No existe la persona que se pretende eliminar.</p>

<?php } else { ?>

	<h1>Error en la eliminación</h1>
	<p>No se ha podido eliminar la persona o la persona no existía.</p>

<?php } ?>

<a href="persona-listado.php">Volver al listado de personas.</a>

</body>

</html>