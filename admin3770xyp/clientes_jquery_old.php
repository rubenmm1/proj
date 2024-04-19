<?php
@session_start();
if (!isset($_SESSION['cod_usuario'])) {
	header("location: index.php");
}

include("../conexion.php");
include("../functions.php");

//data: "cod_cliente="+cod_cliente+"&razon_social="+razon_social+
//"&nombre="+nombre+"&cif="+cif+"&direccion="+direccion+"&telefono="+telefono+
//"&email="+email+"&poblacion="+poblacion+"&provincia="+provincia+"&login="+login+"&pass="+pass+"&pass2="+pass2,

$var_cod_cliente = $_POST['cod_cliente'];

$var_razon_social = htmlspecialchars($_POST['razon_social'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_cif = htmlspecialchars($_POST['cif'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_direccion = htmlspecialchars($_POST['direccion'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_cp = htmlspecialchars($_POST['cp'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_email = htmlspecialchars($_POST['email'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_poblacion = htmlspecialchars($_POST['poblacion'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_provincia = htmlspecialchars($_POST['provincia'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_login = htmlspecialchars($_POST['login'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_pass = htmlspecialchars($_POST['pass'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_pass2 = htmlspecialchars($_POST['pass2'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_cambiarpass = $_POST['cambiarpass'];
$var_iva = $_POST['iva'];
$var_re = $_POST['re'];
$var_tarifa = $_POST['tarifa'];
// $foto_plano = $_POST['foto_plano'];


if ($var_cod_cliente == "0") { // en el caso de ser 0, es un articulo nuevo y hay que obtener el codigo del nuevo articulo
	$var_cod_cliente = obtener_Cod("clientes");
	if (isset($_FILES["file"]["type"])) {
		$tipo_imagen = substr($_FILES["file"]["type"], 6);
		$path_image = "../planos/" . $var_cod_cliente;
		$nom_imagen = "plano_" . $var_cod_cliente . "." . $tipo_imagen;

		if (!file_exists($path_image)) {
			mkdir($path_image, 0777, true);
		}

		if (move_uploaded_file($_FILES["file"]["tmp_name"], $path_image . "/" . $nom_imagen)) {
		}
	}
	$sql = "insert into clientes (cod_cliente,razon_social,nombre,cif,direccion,cp,telefono,email,poblacion,provincia,login,pass,activo,iva,re,id_tarifa,plano)
	values ('" . $var_cod_cliente . "','" . $var_razon_social . "','" . $var_nombre . "','" . $var_cif . "','" . $var_direccion . "','" . $var_cp . "','" . $var_telefono . "','" . $var_email . "','" . $var_poblacion . "','" . $var_provincia . "','" . $var_login . "',SHA1('" . $var_pass . "'),'1'," . $var_iva . "," . $var_re . "," . $var_tarifa . ",'" . $nom_imagen . "')";

} else { //
	if (isset($_FILES["file"]["type"])) {
		$tipo_imagen = substr($_FILES["file"]["type"], 6);
		$path_image = "../planos/" . $var_cod_cliente;
		$nom_imagen = "plano_" . $var_cod_cliente . "." . $tipo_imagen;

		if (!file_exists($path_image)) {
			mkdir($path_image, 0777, true);
		}

		if (move_uploaded_file($_FILES["file"]["tmp_name"], $path_image . "/" . $nom_imagen)) {
		}
	}

	$sql = "update clientes set
	razon_social='" . $var_razon_social . "',
	nombre='" . $var_nombre . "',
	cif='" . $var_cif . "',
	direccion='" . $var_direccion . "',
	cp='" . $var_cp . "',
	telefono='" . $var_telefono . "',
	email='" . $var_email . "',
	poblacion='" . $var_poblacion . "',
	provincia='" . $var_provincia . "',
	iva=" . $var_iva . ",
	re=" . $var_re . ",
	id_tarifa=" . $var_tarifa . ",
	login='" . $var_login . "',plano='" . $nom_imagen . "'";

	if ($var_cambiarpass == "true") {
		$sql = $sql . ", pass=SHA1('" . $var_pass . "') ";
	}
	$sql = $sql . " where cod_cliente='" . $var_cod_cliente . "'";
}


$conexion->query($sql);
if ($tipo_imagen)
	echo json_encode(
		array(
			"cod_cli" => $var_cod_cliente,
			"tipo_imagen" => $tipo_imagen
		)
	);
?>