<?php
    $operando1 = (int)$_REQUEST['operando1'];
    $operando2 = (int)$_REQUEST['operando2'];
    $operacion = $_REQUEST['operacion'];
    $resultado=null;

    $errorDivCero=false;
    if($operando2 == 0)
        $errorDivCero= true;
    if($errorDivCero)
        echo "El dividendo no puede ser 0";
    else {
        if($operacion == 'sum')
            $resultado = $operando1 + $operando2;
        else if($operacion == 'res')
             $resultado = $operando1 - $operando2;
        else if($operacion == 'mul')
            $resultado = $operando1 * $operando2;
        else if($operacion == 'div')
            $resultado = $operando1 / $operando2;
    }
?>
<html>
    <head>
        <title>Resultado</title>
    </head>
    <body>
        <h1>El resultado es:</h1>
        <?php
            switch ($operacion) {
                case "sum":
                    echo "<p>$operando1 + $operando2 = $resultado</p>";
                    break;
                case "res":
                    echo "<p>$operando1 - $operando2 = $resultado</p>";
                    break;
                case "mul":
                    echo "<p>$operando1 * $operando2 = $resultado</p>";
                    break;
                case "div":
                    echo "<p>$operando1 / $operando2 = $resultado</p>";
                    break;

            }

        ?>
    </body>
</html>
