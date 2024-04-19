<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");


$var_cliente = $_POST['cliente'];
$var_f_desde = $_POST['f_desde'];
$var_f_hasta = $_POST['f_hasta'];
$var_tipo = $_POST['tipo'];
$var_factura=$_POST['factura'];
$filtro="";

$return_arr = array();

if ($var_cliente<>""){
	$filtro=$filtro." and razon_social LIKE '%".$var_cliente."%'";
}

if ($var_factura<>""){
	$filtro=$filtro." and id_factura LIKE '%".$var_factura."%'";
}

if($var_tipo<>""){
	$filtro=$filtro." and id_tipo_pago=".$var_tipo;
}

$filtro=$filtro." AND p.fecha BETWEEN '".$var_f_desde."' AND '".$var_f_hasta."'";

$sql="select * from facturas a
inner join clientes c on c.cod_cliente= a.id_cliente
where 1 ".$filtro."
order by fecha asc";

$sql="SELECT tp.descripcion,cod_pago,cif, id_factura, p.fecha AS fecha_pago,pago,cod_factura, razon_social FROM pagos p
INNER JOIN facturas f ON f.cod_factura=p.id_factura
INNER JOIN clientes c ON c.cod_cliente=f.id_cliente
INNER JOIN tipo_pago tp ON tp.cod_tipo_pago=p.id_tipo_pago
where 1 ".$filtro."
order by p.fecha asc";

//echo $sql;

$result = $conexion->query($sql);
if($result->num_rows == 0){// Usuario web no existente
	//echo "No hay clientes";
	$return_arr[] = array("","","","","","");
}else{// existe el usuario web

	while($fila1 = $result->fetch_assoc()){

		$return_arr[] = array(
			"<strong>".$fila1['cod_pago']."</strong>",
			"<strong>".$fila1['razon_social']."</strong> <small>(".$fila1['cif'].")</small>",
			$fila1['id_factura'],
			formatearfecha($fila1['fecha_pago']),
			"<center>".$fila1['descripcion']."</center>",
			"<strong>".$fila1['pago']." €</strong>"
		);
	}
	echo json_encode($return_arr);
}


?>
