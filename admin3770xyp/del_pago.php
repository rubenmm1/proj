<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

$var_codigo = $_POST['cod_pago'];
$var_cod_factura = $_POST['cod_factura'];

$sql="delete FROM pagos WHERE cod_pago=".$var_codigo;

$conexion->query($sql);

$sqlSum="select (importe_descuento+(importe_descuento*(iva+re)/100)) AS Total_iva , (importe_descuento+(importe_descuento*(iva+re)/100))-SUM(pago) AS Debe,SUM(pago) as Pagado,f.* FROM pagos p
INNER JOIN facturas f ON f.cod_factura=p.id_factura
WHERE p.id_factura='".$var_cod_factura."'";

$restultadoSum= $conexion->query($sqlSum);

while($filaSum = $restultadoSum->fetch_assoc()){
	if($filaSum['Debe']==null){
			$sumaPagos=number_format($filaSum['Total_iva'],2,".","");
	}else{
			$sumaPagos =number_format($filaSum['Debe'],2,".","");
	}
}

$sqlPagado="update facturas set pagado=0 where cod_factura='".$var_cod_factura."'";
$conexion->query($sqlPagado);

echo $sumaPagos;
?>
