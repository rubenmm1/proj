<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");

$var_cod = htmlspecialchars($_POST['cod_presupuesto'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$sql="delete from presupuestos_lineas where id_presupuesto='".$var_cod."'";
$conexion->query($sql);
$sql="delete from presupuestos where cod_presupuesto='".$var_cod."'";
$conexion->query($sql);
?>
