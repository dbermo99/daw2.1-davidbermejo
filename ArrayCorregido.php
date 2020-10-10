<?php
$paises= [
    5=> "Francia",
    8=> "España",
    15=> "Alemania",
    17=> "China",
    20=> "Italia",
    22=> "Rumania"
];
$ids= array(17, 5, 43, 24, 47, 34);
?>


<html>
<head>

</head>
<body>


    <select name="paisId">
        <option value="-1">&lt;ELIJA&gt;</option>
        <?php
        foreach ($paises as $id => $nombre) {  //recorres el array paises, y obtienes tanto el id como el nombre
            echo "<option value='$id'>$nombre</option>\n";
        }
        ?>
    </select>

</body>
</html>
