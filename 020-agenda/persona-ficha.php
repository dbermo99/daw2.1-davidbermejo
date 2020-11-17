<?php
	require_once "_varios.php";

	$pdo = obtenerPdoConexionBD();

	$id = (int)$_REQUEST["id"];

	$nueva_entrada = ($id == -1);

	if ($nueva_entrada) {
		$persona_nombre = "<introduzca nombre>";
        $persona_apellido = "<introduzca apellido>";
		$persona_telefono = "<introduzca telefono>";
		$personaCategoriaId = "<introduzca el id de su categoria>";
		$persona_estrella= false;
	} else {
		/*$sql = "SELECT id, estrella, nombre, apellido, telefono, categoria_id FROM persona WHERE id=?";*/
        $sql = "SELECT * FROM persona WHERE id=?";

        $select = $pdo->prepare($sql);
        $select->execute([$id]);
        $rs = $select->fetchAll();

		$persona_estrella = ($rs[0]["estrella"] == 1);
        $persona_nombre = $rs[0]["nombre"];
        $persona_apellido = $rs[0]["apellido"];
        $persona_telefono = $rs[0]["telefono"];
        $personaCategoriaId = $rs[0]["categoria_id"];
	}

	$conexion= obtenerPdoConexionBD();
	$sqlCategorias= "SELECT id, nombre FROM categoria";
	$select= $conexion->prepare($sqlCategorias);
	$select->execute([]);
	$rsCategorias= $select->fetchAll();

?>



<html>

<head>
	<meta charset="UTF-8">
</head>



<body>

<?php if ($nueva_entrada) { ?>
	<h1>Nueva ficha de persona</h1>
<?php } else { ?>
	<h1>Ficha de persona</h1>
<?php } ?>

<form method="post" action="persona-guardar.php">

<input type="hidden" name="id" value="<?=$id?>" />

<ul>
	<li>
		<strong>Nombre: </strong>
		<input type="text" name="nombre" value="<?=$persona_nombre?>" />
	</li>
    <li>
        <strong>Apellido: </strong>
        <input type="text" name="apellido" value="<?=$persona_apellido?>" />
    </li>
    <li>
        <strong>Telefono: </strong>
        <input type="text" name="telefono" value="<?=$persona_telefono?>" />
    </li>
    <li>
        <strong>Categoria id: </strong>
        <select name="categoriaId">
            <?php
                foreach ($rsCategorias as $filaCategoria) {
                    $categoriaId= $filaCategoria["id"];
                    $categoriaNombre= $filaCategoria["nombre"];
                    if($categoriaId == $personaCategoriaId) {
                        $seleccion= "selected= 'true'";
                    } else
                        $seleccion= "";
                    echo "<option value='$categoriaId' $seleccion>$categoriaNombre</option>";
                }
            ?>

        </select>
    </li>
    <li>
        <strong>Estrella: </strong>
        <?php
            if($persona_estrella)
                echo "<input type='checkbox' name='estrella' checked/>";
            else
                echo "<input type='checkbox' name='estrella' />";
        ?>
    </li>
</ul>

<?php if ($nueva_entrada) { ?>
	<input type="submit" name="crear" value="Crear persona" />
<?php } else { ?>
	<input type="submit" name="guardar" value="Guardar cambios" />
<?php } ?>

</form>

<br />

<a href="persona-eliminar.php?id=<?=$id ?>">Eliminar persona</a>

<br />
<br />

<a href="persona-listado.php">Volver al listado de parsonas.</a>

</body>

</html>