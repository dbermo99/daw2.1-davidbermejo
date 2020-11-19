<?php

    /*$oculto = (int) $_REQUEST["oculto"];*/
    session_start();
    if (isset($_REQUEST["oculto"])) {
        $_SESSION["oculto"] = (int) $_REQUEST["oculto"];
    }
    if (!isset($_REQUEST["intento"])) { // Primera vez. Solo viene oculto.
        $intento = null;

        $_SESSION["numIntentos"]= 0;
    } else { // Resto de veces. Vienen todos los datos.
        $intento = (int) $_REQUEST["intento"];

        $_SESSION["numIntentos"] = (int) $_SESSION["numIntentos"] + 1;

        // Esto del logaritmo no es importante. Es solo una manera de que
        // no salga 1.000.000 de asteriscos si hacen un intento de "1000000".
        $numAsteriscos = 1 + log(abs($intento - $_SESSION["oculto"]), 1.5);
        $stringCercania = "";
        for ($i=1; $i <= $numAsteriscos; $i++) {
            $stringCercania = $stringCercania . "*";
        }
    }

    // INTERFAZ:
    // $oculto
    // $intento
    // $numAsteriscos
    // $stringCercania
?>



<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>

<h1>ADIVINA EL NÚMERO</h1>


<?php

    if ($intento == null) {
        // No informamos de nada, el juego acaba de empezar.
    } elseif ($intento < $_SESSION["oculto"]) {
        echo "<p>El número que buscas es mayor ($stringCercania)</p>";
    } elseif ($intento > $_SESSION["oculto"]) {
        echo "<p>El número que buscas es menor ($stringCercania)</p>";
    } else {
        echo "<p>¡Has adivinado el número! Era, efectivamente, ".$_SESSION["oculto"].". Has gastado".$_SESSION["numIntentos"]." intentos.</p>";
    }



    if ($intento != $_SESSION["oculto"]) { // Presentamos el formulario:
?>

        <form method="post">
            <p>Jugador 2: Adivina el número (llevas <?= $_SESSION["numIntentos"] ?> intentos).</p>

            <input type="number" name="intento">
            <input type="submit" value="Intentar">
        </form>

<?php
    }
?>

</body>

</html>