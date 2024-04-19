<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");

$var_cod = htmlspecialchars($_POST['cod_albaran'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$sql="delete from albaranes_lineas where id_albaran='".$var_cod."'";
$conexion->query($sql);
$sql="delete from albaranes where cod_albaran='".$var_cod."'";
$conexion->query($sql);
?>
