<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

//data: "cod_cliente="+cod_cliente+"&razon_social="+razon_social+
//"&nombre="+nombre+"&cif="+cif+"&direccion="+direccion+"&telefono="+telefono+
//"&email="+email+"&poblacion="+poblacion+"&provincia="+provincia+"&login="+login+"&pass="+pass+"&pass2="+pass2,

$var_cod_cliente = $_POST['codigo_cliente'];
$var_iva_cliente = $_POST['iva_cliente'];
$var_observaciones = htmlspecialchars($_POST['observaciones'], ENT_QUOTES | ENT_HTML401, 'UTF-8');

$t_pago_texto=$_POST['t_pago_texto'];
$t_pago_valor=$_POST['t_pago_valor'];

$var_dto_tarifa= $_POST['dto_tarifa'];

$codigo_albaran_enviado=$_POST['cod_albaran'];


$NuevoPresupuesto=false;
$accion="actualizado";


/*
if($NuevoPresupuesto){/// Nuevo presupuesto

	$var_cod_presupuesto=obtener_Cod("presupuestos");
	$anio = date('y');
	$digitos="";
	for($i=0;$i<4-strlen($var_cod_presupuesto);$i++){
		$digitos=$digitos."0";
	}

	$codigo_presupuesto = "P".$anio."-".$digitos.$var_cod_presupuesto;

}else{ /// Modificar presupuesto
*/
	$codigo_albaran=$codigo_albaran_enviado;

	$sql="delete from albaranes_lineas where id_albaran='".$codigo_albaran."'";
	$conexion->query($sql);
/*
}
*/

$articulos = json_decode($_POST['array_articulos']);
$i=0;

//$importeTotal=0;

$importeNeto=0;
$importeConDesc=0;

foreach($articulos  as $articulo){
	//$i =>cod_articulo
	//[0]=>cantidad
	//[1]=>precio
	//[2]=>descripcion
	//[3]=>descuento

	if($articulo[0]<>""){
			//echo $i."=>".$articulo[0]."-".$articulo[1]."-".$articulo[2]."*";
			$subtotal = $articulo[1] * $articulo[0];
			$subtotal=$subtotal-($subtotal*$articulo[3]/100);
			$sql="insert into albaranes_lineas (id_albaran,id_articulo,cantidad,descripcion,precio_unitario,subtotal,desc_linea)
			values ('".$codigo_albaran."','".$i."',".$articulo[0].",'".$articulo[2]."',".$articulo[1].",".$subtotal.",".$articulo[3].")";
			$conexion->query($sql);
			$importeNeto=$importeNeto+$subtotal;
			//echo $sql."<br />";
	}

	$i++;
}

$dtos=floatval(-$var_dto_tarifa+$t_pago_valor);// variable que contiene el % para descontar;

$importeConDesc=$importeNeto+($importeNeto*$dtos/100);

/*
if($NuevoPresupuesto){/// Nuevo presupuesto
	$sql="insert into presupuestos (cod_presupuesto,fecha,id_cliente,importe,iva,observaciones)
	values ('".$codigo_albaran."',NOW(),".$var_cod_cliente.",".$importeTotal.",'".$var_iva_cliente."','".$var_observaciones."')";
}else{
*/
	$sql="Update albaranes SET
	id_cliente=".$var_cod_cliente.",
	importe_neto=".$importeNeto.",
	importe_descuento=".$importeConDesc.",
	iva='".$var_iva_cliente."',
	tiempos_pago_valor=".$t_pago_valor.",
	tiempos_pago_texto='".$t_pago_texto."',
	observaciones='".$var_observaciones."'
	where cod_albaran='".$codigo_albaran."'";
/*
}
*/
$conexion->query($sql);
//echo $sql;

echo $codigo_albaran."#####".$accion;

?>
