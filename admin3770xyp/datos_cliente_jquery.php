<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

$var_codigo = $_POST['codigo'];
$sql="select * from clientes c
	inner join tarifas t on c.id_tarifa=t.cod_tarifa
 where cod_cliente=".$var_codigo;
$conexion->query($sql);
$result = $conexion->query($sql);
while($fila1 = $result->fetch_assoc()){
	$datos = $fila1['razon_social']."####".$fila1['direccion'].",".$fila1['poblacion'].",".$fila1['provincia'].",".$fila1['cp']."####Tel: ".$fila1['telefono']."####Email: ".$fila1['email']."####".$fila1['iva']."####".$fila1['valor']."####".$fila1['re'];
}

echo $datos;
?>
