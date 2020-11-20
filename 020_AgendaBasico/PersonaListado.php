<?php
require_once "_Varios.php";

$conexion = obtenerPdoConexionBD();
session_start();
$sql = "
               SELECT
                    p.id        AS pId,
                    p.nombre    AS pNombre,
                    c.id        AS cId,
                    c.nombre    AS cNombre
                FROM
                   persona AS p INNER JOIN categoria AS c
                   ON p.categoriaId = c.id
                ORDER BY p.nombre
        ";

$select = $conexion->prepare($sql);
$select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
$rs = $select->fetchAll();


if($_SESSION["tema"] == "Oscuro") {
    $_SESSION["tema"]= "Oscuro";
} else {
    $_SESSION["tema"]= "Claro";
}
$URL= "PersonaListado.php";

    // INTERFAZ:
    // $rs
?>



<html>

<head>
    <meta charset='UTF-8'>
    <link rel="stylesheet" type="text/css" href="css/tema<?= $_SESSION["tema"] ?>.css">


</head>



<body>

<?php if($_SESSION["tema"] == "Oscuro") { ?>
    <a href="EstablecerTema.php?ficha=<?=$URL?>">Cambiar a tema claro</a>
<?php } else if($_SESSION["tema"] == "Claro") { ?>
    <a href="EstablecerTema.php?ficha=<?=$URL?>">Cambiar a tema oscuro</a>
<?php } ?>


<h1>Listado de Personas</h1>

<table border='1'>

    <tr>
        <th>Nombre</th>
        <th>Categoría</th>
    </tr>

    <?php
    foreach ($rs as $fila) { ?>
        <tr>
            <td><a href=   'PersonaFicha.php?id=<?=$fila["pId"]?>'> <?= $fila["pNombre"] ?> </a></td>
            <td><a href= 'CategoriaFicha.php?id=<?=$fila["cId"]?>'> <?= $fila["cNombre"] ?> </a></td>
            <td><a href='PersonaEliminar.php?id=<?=$fila["pId"]?>'> (X)                      </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<a href='PersonaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='CategoriaListado.php'>Gestionar listado de Categorías</a>

</body>

</html>