<?php
@session_start();
if (!isset($_SESSION['cod_usuario'])) {
	header("location: index.php");
}

include("../conexion.php");
include("../functions.php");


$var_cod_articulo = $_POST['cod_articulo'];
$var_nombre = $_POST['nombre'];
$var_ns = $_POST['ns'];
$var_cod_cliente = $_POST['cod_cliente'];
$var_descripcion = $_POST['descripcion'];

$var_cod_maquina = $_POST['cod_maquina_modificar'];

if ($var_cod_maquina == "") { /// en el caso de agregar una nueva maquina
	$cod_maquina = obtener_Cod("maquinas");

	$sql = "insert into maquinas (cod_maquina,id_cliente,id_articulo,nombre_maquina,descripcion_maquina,nserie)
	values (" . $cod_maquina . "," . $var_cod_cliente . "," . $var_cod_articulo . ",'" . $var_nombre . "','" . $var_descripcion . "','" . $var_ns . "')";

} else { // En el caso de modificar la maquina ya existente

	$sql = "update maquinas set id_articulo=" . $var_cod_articulo . ",nombre_maquina='" . $var_nombre . "',descripcion_maquina='" . $var_descripcion . "',nserie='" . $var_ns . "'
	where cod_maquina=" . $var_cod_maquina;
}


$conexion->query($sql);

//echo $sql;


?>