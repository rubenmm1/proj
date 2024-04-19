<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

@session_start();
if (!isset($_SESSION['cod_usuario'])) {
	header("location: index.php");
	exit();
}

include("../conexion.php");
include("../functions.php");


$var_cod_revision = htmlspecialchars($_POST['cod_revision'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_cod_cliente = htmlspecialchars($_POST['codigo_cliente'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_iva_cliente = htmlspecialchars($_POST['iva_cliente'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_re_cliente = htmlspecialchars($_POST['re_cliente'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_dto_tarifa = htmlspecialchars($_POST['dto_tarifa'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_cod_serie = htmlspecialchars($_POST['cod_serie'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_observaciones = htmlspecialchars($_POST['observaciones'], ENT_QUOTES | ENT_HTML401, 'UTF-8');


//data: "cod_cliente="+cod_cliente+"&razon_social="+razon_social+
//"&nombre="+nombre+"&cif="+cif+"&direccion="+direccion+"&telefono="+telefono+
//"&email="+email+"&poblacion="+poblacion+"&provincia="+provincia+"&login="+login+"&pass="+pass+"&pass2="+pass2,

// Validate POST data
// if (!$var_cod_revision || !$var_cod_cliente || !$var_iva_cliente || !$var_re_cliente || !$var_dto_tarifa || !$var_cod_serie) {
// 	// Handle invalid or missing data
// 	echo json_encode(['success' => false, 'message' => 'Invalid or missing data']);
// 	exit();
// }

$codigo_presupuesto_enviado = $_POST['cod_presupuesto'];


if ($codigo_presupuesto_enviado == "0") { /// Nuevo presupuesto
	$NuevoPresupuesto = true;
	$accion = "creado";
} else {
	$NuevoPresupuesto = false;
	$accion = "actualizado";
}


if ($NuevoPresupuesto) { /// Nuevo presupuesto

	$codigo_presupuesto = obtener_series($var_cod_serie, "P");
} else { /// Modificar presupuesto

	$codigo_presupuesto = $codigo_presupuesto_enviado;

	$sql = "delete from presupuestos_lineas where id_presupuesto='" . $codigo_presupuesto . "'";
	$conexion->query($sql);
}


$articulos = $_POST['array_articulos'];
$articulosData = $_POST['array_articulosData'];
$i = 0;

// print_r($articulos);

$importeNeto = 0;
$importeConDesc = 0;

foreach ($articulos as $key => $articulo) {
	// Check if $articulo is not empty
	if (!empty($articulo)) {
		// Access elements using keys
		$cantidad = $articulosData[$key]['cantidad'];
		$precio = $articulo['precio'];
		$descripcion = $articulosData[$key]['descripcion'];
		$id_articulo = $articulosData[$key]['id_articulo'];
		$descuento_linea = 0;
		// Calculate subtotal
		$subtotal = $precio * $cantidad;
		$subtotal -= ($subtotal * $descuento_linea / 100);

		// Insert into presupuestos_lineas table
		$sql = "INSERT INTO presupuestos_lineas (id_presupuesto, id_articulo, cantidad, descripcion, precio_unitario, subtotal, desc_linea)
                VALUES ('$codigo_presupuesto', '$id_articulo', $cantidad, '$descripcion', $precio, $subtotal, $descuento_linea)";
		$conexion->query($sql);

		// Update importeNeto
		$importeNeto += $subtotal;
	}

	$i++;
}


$dto = $var_dto_tarifa; // variable que contiene el % para descontar;
// echo $dto;
$importeConDesc = $importeNeto - ($importeNeto * $dto / 100);

if ($NuevoPresupuesto) { /// Nuevo presupuesto
	$sql = "insert into presupuestos (cod_presupuesto,fecha,id_cliente,importe_neto,importe_descuento,iva,observaciones,tarifa,cod_serie,re)
	values ('" . $codigo_presupuesto . "',NOW()," . $var_cod_cliente . "," . $importeNeto . "," . $importeConDesc . ",'" . $var_iva_cliente . "','" . $var_observaciones . "'," . $var_dto_tarifa . "," . $var_cod_serie . "," . $var_re_cliente . ")";
	// echo "<script>console.log('sql to insert new presupuesto');</script>";
} else {
	$sql = "Update presupuestos SET
	id_cliente=" . $var_cod_cliente . ",
	importe_neto=" . $importeNeto . ",
	importe_descuento=" . $importeConDesc . ",
	iva='" . $var_iva_cliente . "',
	observaciones='" . $var_observaciones . "',
	tarifa='" . $var_dto_tarifa . "'
	where cod_presupuesto='" . $codigo_presupuesto . "'";
}
$conexion->query($sql);

echo $sql;

// echo $codigo_presupuesto."#####".$accion;
