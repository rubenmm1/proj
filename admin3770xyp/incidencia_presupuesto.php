<?php
@session_start();
if (!isset($_SESSION['cod_usuario'])) {
	header("location: index.php");
}

include("../conexion.php");
include("../functions.php");

$sql = "insert into presupuestos (cod_presupuesto,fecha,id_cliente,importe_neto,importe_descuento,iva,observaciones,tarifa,cod_serie,re)
	values ('" . $codigo_presupuesto . "',NOW()," . $var_cod_cliente . "," . $importeNeto . "," . $importeConDesc . ",'" . $var_iva_cliente . "','" . $var_observaciones . "'," . $var_dto_tarifa . "," . $var_cod_serie . "," . $var_re_cliente . ")";

$conexion->query($sql);
$result = $conexion->query($sql);
while ($fila1 = $result->fetch_assoc()) {
	$datos = $fila1['razon_social'] . "####" . $fila1['direccion'] . "," . $fila1['poblacion'] . "," . $fila1['provincia'] . "," . $fila1['cp'] . "####Tel: " . $fila1['telefono'] . "####Email: " . $fila1['email'] . "####" . $fila1['iva'] . "####" . $fila1['valor'] . "####" . $fila1['re'];
}

echo $datos;
