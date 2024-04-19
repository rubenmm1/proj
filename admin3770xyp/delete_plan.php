<?php
require_once('../conexion.php');
$cod_cli = $_POST['cod_cli'];

$sql = "UPDATE clientes set plano=null where cod_cliente=" . $cod_cli;
$conexion->query($sql);

if (!$conexion->error) {
    $sql = "UPDATE maquinas set posicion_plano_x=null,posicion_plano_y=null where id_cliente=" . $cod_cli;
    $conexion->query($sql);

    if (!$conexion->error)
        echo 'success';
    else
        return;
} else
    return;




?>