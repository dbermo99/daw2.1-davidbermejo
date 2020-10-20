<?php
$secreto=null;
$introducido=null;
if(isset($_POST['ocultar'])){
    $secreto = $_POST['numero'];
}
if( isset($_POST['comparar']) && isset($_POST['numero']) ){
    $introducido = $_POST['introducido'];
    if($introducido == $secreto) {
        echo "Has acertado";
    } else {
        echo "Sigue probando";
    }
} else
    echo "No hay n secreto";


?>

<html>
    <head>
        <title>Adivina el numero</title>
    </head>
    <body>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <p>Indica un numero para ocultar</p>
            <input type="number" name="numero">
            <input type="submit" name="ocultar" value="Ocultar"><br\>
            <p>Indica un numero para intentar averigura</p>
            <input type="number" name="introducido">
            <input type="submit" name="comparar" value="Comparar">
        </form>

    </body>
</html>
