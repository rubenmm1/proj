<?php
require_once('../conexion.php');

$cod_cli = $_POST['cod_cliente'];

$sql = "SELECT nserie,posicion_plano_x,posicion_plano_y FROM maquinas WHERE id_cliente = " . $cod_cli;
$result = $conexion->query($sql);
$data = [];
while ($fila = $result->fetch_assoc()) {
    array_push($data, $fila);
}

if (!$conexion->error)
    echo json_encode($data);
else
    return;
?>