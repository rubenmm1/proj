<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

if(isset($_POST['cod_presupuesto'])){

	$cod_tiempo_pago=$_POST['cod_tiempo_pago'];
	$codigo_presupuesto_enviado=$_POST['cod_presupuesto'];

	$sql="select * from presupuestos where cod_presupuesto='".$codigo_presupuesto_enviado."'";
	$r=$conexion->query($sql);

	while($f = $r->fetch_assoc()){
		$var_cod_serie=$f['cod_serie'];
	}

	$var_cod_albaran=obtener_series($var_cod_serie,"A");

	/***********************************/
	/* Se crean las lineas del albaran */
	/***********************************/

	$sql="select * from presupuestos_lineas where id_presupuesto='".$codigo_presupuesto_enviado."'";

	$result=$conexion->query($sql);

	if($result->num_rows == 0){// Presupuesto no existente
		echo "No existe el presupuesto";
	}else{// existe el usuario web
		while($fila1 = $result->fetch_assoc()){

			$sql="insert into albaranes_lineas (id_albaran,id_articulo,cantidad,descripcion,precio_unitario,subtotal,desc_linea)
			values ('".$var_cod_albaran."','".$fila1['id_articulo']."',".$fila1['cantidad'].",'".$fila1['descripcion']."',".$fila1['precio_unitario'].",".$fila1['subtotal'].",".$fila1['desc_linea'].")";
			$conexion->query($sql);
			//echo $sql;

		}
	}// FIN if($result->num_rows == 0){// Presupuesto no existente


/***********************************/
/* Se crea la cabecera del albaran */
/***********************************/

		$sql="select * from presupuestos
		where cod_presupuesto='".$codigo_presupuesto_enviado."'";

		$resultP=$conexion->query($sql);

/* Obtengo tiempos de pagos*/
	$sql_tp="select * from tiempos_pago where cod_tiempos_pago=".$cod_tiempo_pago;
	$resultado = $conexion->query($sql_tp);
	while ($filatp=$resultado->fetch_assoc()){
		$t_pagos_valor=$filatp['valor'];
		$t_pagos_texto=$filatp['descripcion'];
	}
	//echo $sql_tp;


	if($resultP->num_rows == 0){// Presupuesto no existente
		echo "No existe el presupuesto";
	}else{// existe el usuario web
		while($filaP = $resultP->fetch_assoc()){
			$importe_neto=$filaP['importe_neto'];
			$todos_descuentos = $t_pagos_valor-$filaP['tarifa'];
			$importe_descuento = $importe_neto+($importe_neto*$todos_descuentos/100);
			$sql="insert into albaranes (cod_albaran,fecha,id_cliente,importe_neto,importe_descuento,iva,observaciones,tiempos_pago_valor,tiempos_pago_texto,tarifa,cod_serie,re)
			values ('".$var_cod_albaran."',NOW(),".$filaP['id_cliente'].",".$importe_neto.",".$importe_descuento.",'".$filaP['iva']."','".$filaP['observaciones']."',".$t_pagos_valor.",'".$t_pagos_texto."',".$filaP['tarifa'].",".$var_cod_serie.",".$filaP['re'].")";
			$conexion->query($sql);
			//echo $sql;
		}
	}// FIN if($resultP->num_rows == 0){// Presupuesto no existente


/************************************************/
/* Se añade el codigo de albaran al presupuesto */
/************************************************/

	$sql="update presupuestos set
	albaran='".$var_cod_albaran."',	aceptado=1
	where cod_presupuesto='".$codigo_presupuesto_enviado."'";

	$conexion->query($sql);

}//FIN if(isset($_POST['cod_presupuesto'])){
?>
