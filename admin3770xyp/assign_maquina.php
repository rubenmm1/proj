<?php
require_once('../conexion.php');
$cod_maquina = $_POST['cod_maquina'];
$posY = $_POST['y'];
$posX = $_POST['x'];

$sql = "UPDATE maquinas SET posicion_plano_x = " . $posX . " , posicion_plano_y = " . $posY . " WHERE cod_maquina = " . $cod_maquina;
$conexion->query($sql);

if (!$conexion->error) {

    $sql = "SELECT nserie FROM maquinas WHERE cod_maquina = " . $cod_maquina;
    $nserie = $conexion->query($sql)->fetch_assoc()['nserie'];
}

if (!$conexion->error) {

    // echo 'Máquina asignada';
    echo $nserie;
}

return;
?>