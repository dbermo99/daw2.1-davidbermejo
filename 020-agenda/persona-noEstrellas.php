<?php

require_once "_varios.php";

$pdo = obtenerPdoConexionBD();

$sql = "
           SELECT
                p.id     AS p_id,
                p.estrella AS p_estrella,
                p.nombre AS p_nombre,
                p.nombre AS p_nombre,
                p.apellido AS p_apellido,
                p.telefono AS p_telefono,
                p.categoria_id AS p_categoriaId,
                c.id     AS c_id,
                c.nombre AS c_nombre
            FROM
               persona p, categoria c
               WHERE p.categoria_id = c.id && p.estrella is null 
            ORDER BY p.nombre
    ";

$select = $pdo->prepare($sql);
$select->execute([]);
$rs = $select->fetchAll();
?>

<html>

<head>
    <meta charset="UTF-8">
</head>



<body>

<h1>Listado de Personas</h1>

<table border="1">

    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Telefono</th>
        <th>CategoriaId</th>
    </tr>

    <?php
    foreach ($rs as $fila) { ?>
        <tr>

            <td><a href="persona-ficha.php?id=<?=$fila["p_id"]?>">
                    <?php if(isset($fila["p_estrella"])) { ?>
                        <img src="estrella.jpg" width="10" height="10">
                    <?php } else ?>
                    <?= $fila["p_nombre"] ?>
                </a></td>


            <td><a href="persona-ficha.php?id=<?=$fila["p_id"]?>"> <?=$fila["p_apellido"] ?> </a></td>
            <td><a href="persona-ficha.php?id=<?=$fila["p_id"]?>"> <?=$fila["p_telefono"] ?> </a></td>
            <td><a href="persona-ficha.php?id=<?=$fila["p_id"]?>"> <?=$fila["p_categoriaId"] ?> </a></td>
            <td><a href="persona-eliminar.php?id=<?=$fila["p_id"]?>"> (X)                   </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<a href="persona-ficha.php?id=-1">Crear entrada</a>

<br />
<br />

<a href="categoria-listado.php">Gestionar listado de Categorias</a>
<br />
<a href="persona-listado.php">Gestionar listado de personas</a>
<br />
<a href="persona-estrellas.php">Gestionar listado de personas con estrellas</a>

</body>

</html>