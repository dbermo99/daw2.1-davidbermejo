<?php
?>

<html>
    <head>
        <title>Calculadora</title>
    </head>
    <body>
        <form action="12b-calculadora-resultado.php" name="calculadora">
            <p>Indica una operacion</p>
            <input type="number" name="operando1">
            <select name="operacion">
                <option value="sum">+</option>
                <option value="res">-</option>
                <option value="mul">*</option>
                <option value="div">/</option>
            </select>
            <input type="number" name="operando2">
            <input type="submit">
        </form>
    </body>
</html>
