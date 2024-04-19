<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

if(isset($_POST['cod_albaran'])){


	$codigo_albaran_enviado=$_POST['cod_albaran'];
	$sql="select * from albaranes where cod_albaran IN ('".$codigo_albaran_enviado."')";
	$r=$conexion->query($sql);

	while($f = $r->fetch_assoc()){
		$var_cod_serie=$f['cod_serie'];
	}

	$var_cod_factura=obtener_series($var_cod_serie,"F");

	/***********************************/
	/* Se crean las lineas del albaran */
	/***********************************/

	$sql="select * from albaranes_lineas where id_albaran IN ('".$codigo_albaran_enviado."')";

	$result=$conexion->query($sql);

	$total_factura_neto=0;

	if($result->num_rows == 0){// Presupuesto no existente
		//echo "No existe el albarán";
	}else{// existe el usuario web
		while($fila1 = $result->fetch_assoc()){

			$sql="insert into facturas_lineas (id_factura,id_articulo,cantidad,descripcion,precio_unitario,subtotal,desc_linea)
			values ('".$var_cod_factura."','".$fila1['id_articulo']."',".$fila1['cantidad'].",'".$fila1['descripcion']."',".$fila1['precio_unitario'].",".$fila1['subtotal'].",".$fila1['desc_linea'].")";
			$total_factura_neto=$total_factura_neto+$fila1['subtotal'];
			$conexion->query($sql);
			//echo $sql;

		}
	}// FIN if($result->num_rows == 0){// Presupuesto no existente


/*************************************/
/* Se crea la cabecera de la factura */
/*************************************/

		$sql="select a.re as re_cliente, c.iva as iva_cliente, c.cod_cliente, a.observaciones as observaciones_albaran, a.* from albaranes a
		inner join clientes c on c.cod_cliente=a.id_cliente
		where cod_albaran IN ('".$codigo_albaran_enviado."')";

		$resultP=$conexion->query($sql);

		if($resultP->num_rows == 0){// Presupuesto no existente
			//echo "No existe la factura";
		}else{// existe el usuario web
			while($filaP = $resultP->fetch_assoc()){

				/*
				$sql="insert into facturas (cod_factura,fecha,id_cliente,importe,iva,observaciones)
				values ('".$var_cod_factura."',NOW(),".$filaP['id_cliente'].",".$filaP['importe'].",'".$filaP['iva']."','".$filaP['observaciones']."')";
				*/

				$todas_observaciones=$todas_observaciones."\n".$filaP['observaciones_albaran'];
				$cliente= $filaP['cod_cliente'];
				$iva_cliente= $filaP['iva_cliente'];
				$re_cliente= $filaP['re_cliente'];


				$tiempos_pago_valor= $filaP['tiempos_pago_valor'];
				$tiempos_pago_texto= $filaP['tiempos_pago_texto'];
				$tarifa_cliente=$filaP['tarifa'];
				$todos_descuentos = $tiempos_pago_valor-$tarifa_cliente;

				//$conexion->query($sql);
				//echo $sql;
			}
		}// FIN if($resultP->num_rows == 0){// Presupuesto no existente


			//$importe_neto=$filaP['importe_neto'];

			$total_factura_descuento = $total_factura_neto+($total_factura_neto*$todos_descuentos/100);


			$sql="insert into facturas (cod_factura,fecha,id_cliente,importe_neto,importe_descuento,iva,observaciones,tarifa,tiempos_pago_valor,tiempos_pago_texto,re)
			values ('".$var_cod_factura."',NOW(),".$cliente.",".$total_factura_neto.",".$total_factura_descuento.",'".$iva_cliente."','".$todas_observaciones."',".$tarifa_cliente.",".$tiempos_pago_valor.",'".$tiempos_pago_texto."',".$re_cliente.")";

			$conexion->query($sql);
			//echo $sql;

/************************************************/
/* Se añade el codigo de albaran al presupuesto */
/************************************************/

	$sql="update albaranes set
	factura='".$var_cod_factura."'
	where cod_albaran IN ('".$codigo_albaran_enviado."')";

	$conexion->query($sql);

	echo $var_cod_factura;
}//FIN if(isset($_POST['cod_presupuesto'])){
?>
