<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");

$var_cod_articulo = htmlspecialchars($_POST['cod_articulo'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$sql="update articulos set
activo=0
where cod_articulo='".$var_cod_articulo."'";

$conexion->query($sql);

?>
