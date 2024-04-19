<?php
@session_start();
if (!isset($_SESSION['cod_cliente']))
{
	header("location: index.php");
}

include ("conexion.php");
include ("functions.php");


$var_cod_presupuesto = $_POST['cod_presupuesto'];
$var_accion = $_POST['accion'];
if($var_accion=="aceptar"){
	$sql="update presupuestos set aceptado=1 where cod_presupuesto='".$var_cod_presupuesto."'";
	$conexion->query($sql);
}

?>
