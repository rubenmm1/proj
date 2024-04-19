<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");

$var_cod = htmlspecialchars($_POST['cod_cliente'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$sql="update clientes set
activo=0
where cod_cliente='".$var_cod."'";

$conexion->query($sql);

?>
