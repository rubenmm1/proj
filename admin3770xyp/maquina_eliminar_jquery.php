<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");

$var_cod_maquina = htmlspecialchars($_POST['cod_maquina'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$sql="update maquinas set activa=0
where cod_maquina='".$var_cod_maquina."'";

$conexion->query($sql);

?>
