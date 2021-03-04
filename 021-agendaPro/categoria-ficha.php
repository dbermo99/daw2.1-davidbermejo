<?php
	require_once "_varios.php";

	$pdo = obtenerPdoConexionBD();

	$id = (int)$_REQUEST["id"];

	$nueva_entrada = ($id == -1);

	if ($nueva_entrada) {
		$categoria_nombre = "<introduzca nombre>";
	} else {
		$sql = "SELECT nombre FROM categoria WHERE id=?";

        $select = $pdo->prepare($sql);
        $select->execute([$id]);
        $rs = $select->fetchAll();

		$categoria_nombre = $rs[0]["nombre"];

        $sql2 = "SELECT nombre, apellido FROM persona  WHERE categoria_id = $id";

        $select2 = $pdo->prepare($sql2);
        $select2->execute([]);
        $rs2 = $select2->fetchAll();

	}



?>



<html>

<head>
	<meta charset="UTF-8">
</head>



<body>

<?php if ($nueva_entrada) { ?>
	<h1>Nueva ficha de categoría</h1>
<?php } else { ?>
	<h1>Ficha de categoría</h1>
<?php } ?>

<form method="post" action="categoria-guardar.php">

<input type="hidden" name="id" value="<?=$id?>" />

<ul>
	<li>
		<strong>Nombre: </strong>
		<input type="text" name="nombre" value="<?=$categoria_nombre?>" />
	</li>
</ul>

<?php if ($nueva_entrada) { ?>
	<input type="submit" name="crear" value="Crear categoría" />
<?php } else { ?>
	<input type="submit" name="guardar" value="Guardar cambios" />
<?php } ?>

</form>

<br />

<a href="categoria-eliminar.php?id=<?=$id ?>">Eliminar categoría</a>

<br />
<br />

<a href="categoria-listado.php">Volver al listado de categorías.</a>

<?php if(!$nueva_entrada) {
            foreach ($rs2 as $fila) {?>

                <ul>
                    <li><?=$fila["nombre"]?> <?=$fila["apellido"]?></li>
                </ul>

<?php } } ?>

</body>

</html>