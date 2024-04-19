<?php
@session_start();
if (!isset($_SESSION['cod_usuario'])) {
    header("location: index.php");
}

include("../conexion.php");
include("../functions.php");

//data: "cod_foto=" + cod_foto +"&nombre_foto="+nom_foto,

$var_foto = filter_input(INPUT_POST, "cod_foto");
$var_nombre_foto = filter_input(INPUT_POST, "nombre_foto");
$var_cod_revision = filter_input(INPUT_POST, "cod_revision");


if (!empty($var_foto)) { // foto ya guardada    
    $f_eliminar = "./fotos/revisiones/" . $var_cod_revision . "/" . $var_nombre_foto;
    $sql = "delete from revisiones_fotos where cod_revisiones_fotos=" . $var_foto;
    $conexion->query($sql);
} else {
    $f_eliminar = "./temp/" . $var_nombre_foto;
}

unlink($f_eliminar);
