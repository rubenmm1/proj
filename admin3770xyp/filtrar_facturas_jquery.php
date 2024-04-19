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
$var_pagada = $_POST['pagada'];
$filtro="";

$return_arr = array();

if ($var_cliente<>""){
	$filtro=$filtro." and razon_social LIKE '%".$var_cliente."%'";
}

if($var_pagada=="true"){
	$filtro=$filtro." and pagado=0 ";
}

$filtro=$filtro." AND fecha BETWEEN '".$var_f_desde."' AND '".$var_f_hasta."'";

$sql="select * from facturas a
inner join clientes c on c.cod_cliente= a.id_cliente
where 1 ".$filtro."
order by fecha asc";


$result = $conexion->query($sql);
if($result->num_rows == 0){// Usuario web no existente
	//echo "No hay clientes";
	$return_arr[] = array("","","","","","");
}else{// existe el usuario web

	while($fila1 = $result->fetch_assoc()){
		$tipo_factura=substr($fila1['cod_factura'],0,1);
		if($tipo_factura<>"R"){// factura
			if($fila1['pagado']<>0){
				$pagado="<div class='badge bg-success'>Pagada</div>";
			}else{
				$pagado="<div class='badge bg-danger btn_pasar_albaran puntero' cod='".$fila1['cod_presupuesto']."'>Pendiente</div>";
			}
		}else{// Restificativa
			$pagado="<div class='badge bg-info'>Abono</div>";
		}
/*
	echo
	"<tr id='reg_".$fila1['cod_factura']."'>
		<td class=' text-center tx-bold wd-5p'>".$fila1['cod_factura']."</td>
		<td class='tx-bold wd-20p'>".$fila1['razon_social']." <small>(".$fila1['cif'].")</small></td>
		<td class='small'>".$fila1['observaciones']."</td>
		<td class='text-center wd-10p'>".formatearfecha($fila1['fecha'])."</td>
		<td class='text-right tx-bold wd-5p'>".$fila1['importe_descuento']." €</td>
		<td class='text-center wd-10p'>".$pagado."</td>
		<td class='text-right  wd-5p'><i class='fa fa-eye btn_modificar puntero' cod=".$fila1['cod_factura']."></i></td>
	</tr>";
	*/
	//echo "'".$fila1['cod_factura']."'######'".$fila1['razon_social']." <small>(".$fila1['cif'].")'######'".$fila1['observaciones']."'######'".formatearfecha($fila1['fecha'])."'######'".$fila1['importe_descuento']." €'######'".$pagado."'######'<i class='fa fa-eye btn_modificar puntero' cod=".$fila1['cod_factura'].">'";

	//echo "'".$fila1['cod_factura']."','".$fila1['razon_social']." <small>(".$fila1['cif'].")','".$fila1['observaciones']."','".formatearfecha($fila1['fecha'])."','".$fila1['importe_descuento']." €','".$pagado."','<i class='fa fa-eye btn_modificar puntero' cod=".$fila1['cod_factura'].">'";
	//echo "*********";

		$return_arr[] = array(
			"<strong>".$fila1['cod_factura']."</strong>",
			"<strong>".$fila1['razon_social']."</strong> <small>(".$fila1['cif'].")</small>",
			"<small>".$fila1['observaciones']."</small>",
			formatearfecha($fila1['fecha']),
			"<strong>".$fila1['importe_descuento']." €</strong>",
			"<center>".$pagado."</center>"
		//	"<i class='fa fa-eye btn_modificar puntero' cod=".$fila1['cod_factura'].">"
		);
	}
	echo json_encode($return_arr);
}


?>
