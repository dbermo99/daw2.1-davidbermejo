<?php

$oculto = (int) $_REQUEST["oculto"];

if (isset($_REQUEST["introducido"]))
    $introducido = (int) $_REQUEST["introducido"];

 else
     $introducido = null;

?>



<html>

<head>
    <title>Adivina el numero</title>
</head>

<body>

<h1>ADIVINA EL NÚMERO</h1>


<?php

if ($introducido != $oculto) { // Presentamos el formulario:

    ?>

    <form method="post">
        <p>Adivina el número</p>
        <input type="hidden" name="oculto" value="<?= $oculto ?>">
        <input type="number" name="introducido">
        <input type="submit" value="enviar">
    </form>

    <?php

}

if ($introducido == null) {

} else if ($introducido < $oculto) {
    echo "<p>El número que buscas es mayor</p>";
} else if ($introducido > $oculto) {
    echo "<p>El número que buscas es menor</p>";
} else {
    echo "<p>¡Has adivinado el número! Era, efectivamente, $oculto.</p>";
}

?>

</body>

</html>