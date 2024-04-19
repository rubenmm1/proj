<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

if(isset($_POST['cod_factura'])){

	$codigo_factura_enviado=$_POST['cod_factura'];

	$var_cod_rest=obtener_Cod("restificativas");
	$anio = date('y');
	$digitos="";
	for($i=0;$i<4-strlen($var_cod_rest);$i++){
		$digitos=$digitos."0";
	}

	$var_cod_rest = "FR".$anio."-".$digitos.$var_cod_rest;


	/**************************************/
	/* Se crean las lineas de la factura  */
	/**************************************/

	$sql="select * from facturas_lineas where id_factura = '".$codigo_factura_enviado."'";

	$result=$conexion->query($sql);

	$total_factura_neto=0;

	if($result->num_rows == 0){// Presupuesto no existente
		//echo "No existe el albarán";
	}else{// existe el usuario web
		while($fila1 = $result->fetch_assoc()){

			$sql="insert into facturas_lineas (id_factura,id_articulo,cantidad,descripcion,precio_unitario,subtotal,desc_linea)
			values ('".$var_cod_rest."','".$fila1['id_articulo']."',-".$fila1['cantidad'].",'".$fila1['descripcion']."',".$fila1['precio_unitario'].",-".$fila1['subtotal'].",".$fila1['desc_linea'].")";
			$conexion->query($sql);
			//echo $sql;

		}
	}// FIN if($result->num_rows == 0){// Presupuesto no existente


/*************************************/
/* Se crea la cabecera de la factura */
/*************************************/

		$sql="select * from facturas where cod_factura = '".$codigo_factura_enviado."'";

		$resultP=$conexion->query($sql);

		if($resultP->num_rows == 0){// Presupuesto no existente
			//echo "No existe la factura";
		}else{// existe el usuario web
			while($filaP = $resultP->fetch_assoc()){

				$sql="insert into facturas (cod_factura,fecha,id_cliente,importe_neto,importe_descuento,iva,observaciones,tarifa,tiempos_pago_valor,tiempos_pago_texto)
				values ('".$var_cod_rest."',NOW(),".$filaP['id_cliente'].",-".$filaP['importe_neto'].",-".$filaP['importe_descuento'].",'".$filaP['iva']."','Abono factura ".$codigo_factura_enviado.": ".$filaP['observaciones']."',".$filaP['tarifa'].",".$filaP['tiempos_pago_valor'].",'".$filaP['tiempos_pago_texto']."')";

				$conexion->query($sql);
			}
		}// FIN if($resultP->num_rows == 0){// Presupuesto no existente

}//FIN if(isset($_POST['cod_presupuesto'])){
?>
