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
               WHERE p.categoria_id = c.id
            ORDER BY p.nombre
    ";
    $ficha= "persona-listado.php";

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
                    <?php if($fila["p_estrella"] == 1) { ?>
                        <?= $fila["p_nombre"] ?> <a href="personaCambiarEstadoEstrella.php?id=<?=$fila["p_id"]?>&ficha=<?=$ficha?>"><img src="estrella.jpg" width="10" height="10"></a>
                    <?php } else {?>
                        <?= $fila["p_nombre"] ?> <a href="personaCambiarEstadoEstrella.php?id=<?=$fila["p_id"]?>&ficha=<?=$ficha?>"><img src="estrellaVacia.jpg" width="10" height="10"></a>
                    <?php } ?>
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
<a href="persona-estrellas.php">Listado personas con estrellas</a>
<br />
<a href="persona-noEstrellas.php">Listado personas sin estrellas</a>

</body>

</html>