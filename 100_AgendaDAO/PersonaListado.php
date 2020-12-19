<?php
    require_once "_com/Varios.php";
	require_once "_com/dao.php";

    $personas = DAO::personaObtenerTodas();
    
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Listado de Personas</h1>

<table border='1'>

    <tr>
        <th>Persona</th>
        <th>Categoria</th>
    </tr>

    <?php
    foreach ($personas as $persona) { ?>
        <tr>
            <td><a href= 'PersonaFicha.php?id=<?=$persona->getId()?>'> <?= $persona->getNombre() ?> </a></td>
            <td><a href= 'CategoriaFicha.php?id=<?=$persona->getCategoriaId()?>'> <?= DAO::personaCategoria($persona->getCategoriaId()) ?> </a></td>
            <td><a href='PersonaEliminar.php?id=<?=$persona->getId()?>'> (X)                      </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<?php if (!isset($_SESSION["soloEstrellas"])) {?>
    <a href='PersonaListado.php?soloEstrellas'>Mostrar solo contactos con estrella</a>
<?php } else { ?>
    <a href='PersonaListado.php?todos'>Mostrar todos los contactos</a>
<?php } ?>

<br />
<br />

<a href='PersonaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='CategoriaListado.php'>Gestionar listado de Categorías</a>

</body>

</html>