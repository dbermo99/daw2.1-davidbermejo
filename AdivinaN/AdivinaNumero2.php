<?php
    $numeroOculto=null;
    $introducido=null;
    if(isset($_POST["numero"])) {
        $numeroOculto = (int)$_POST["numero"];
    }
    if(isset($_REQUEST["introducido"])) {
        $introducido= $_REQUEST["introducido"];
    }
    function comparar(){
        echo numeroOculto;
        echo introducido;
        if(oculto == introducido)
            echo "Has acertado";
        else
            echo "Sigue intentandolo";
    }


?>
<html>
    <head>
        <title>Adivina el Numero</title>
    </head>
    <body>
        <script>
            var introducido=null;
            function compara() {
                introducido= document.getElementById("introducido").value;
                if(<?=$numeroOculto?> == introducido)
                    document.write("Has acertado");

            }

        </script>
        <form method="get">
            <p>Indica un numero:</p>
            <input type="number" name="introducido>" value="<?=$introducido?>" id="introducido">
            <button onclick="compara()">Compara</button>
        </form>
    </body>
</html>
