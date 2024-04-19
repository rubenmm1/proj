<?php
@session_start();
if (!isset($_SESSION['cod_usuario'])) {
    header("location: index.php");
}

include("../conexion.php");
include("../functions.php");

$date = new DateTime();
$codigo_revision = filter_input(INPUT_POST, "cod_revision");
$nombre_firma = filter_input(INPUT_POST, "nom_firma");

if (!empty($codigo_revision)) {
    $f_eliminar = "../firmas/revisiones/" . $nombre_firma;
    $sql = "UPDATE revisiones SET firma=null, fecha_firma='" . $date->format('Y-m-d H:i:s') . "' WHERE cod_revision='" . $codigo_revision . "'";
    $conexion->query($sql);
}

unlink($f_eliminar);
