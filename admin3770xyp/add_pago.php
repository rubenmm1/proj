<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

$var_cod_factura = $_POST['cod_factura'];
$var_tipo_pago = $_POST['cod_tipo'];
$var_importe = htmlspecialchars($_POST['importe'], ENT_QUOTES | ENT_HTML401, 'UTF-8');

$cod_pago=obtener_Cod("pagos");

$sql="insert into pagos (cod_pago,id_factura,id_tipo_pago,fecha,pago)
values (".$cod_pago.",'".$var_cod_factura."',".$var_tipo_pago.",NOW(),".$var_importe.")";

$conexion->query($sql);

$sqlSum="select (importe_descuento+(importe_descuento*(iva+re)/100)) AS Total_iva , (importe_descuento+(importe_descuento*(iva+re)/100))-SUM(pago) AS Debe,SUM(pago) as Pagado,f.* FROM pagos p
INNER JOIN facturas f ON f.cod_factura=p.id_factura
WHERE p.id_factura='".$var_cod_factura."'";

$restultadoSum= $conexion->query($sqlSum);
while($filaSum = $restultadoSum->fetch_assoc()){
	$sumaPagos =$filaSum['Debe'];
}

if($sumaPagos<=0){// marcar factura como pagada
	$sqlPagado="update facturas set pagado=1 where cod_factura='".$var_cod_factura."'";
	//echo $sqlPagado;
	$conexion->query($sqlPagado);
}

echo $sumaPagos."#####".$cod_pago;
?>
