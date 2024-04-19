<?php
@session_start();
if (!isset ($_SESSION['cod_usuario'])) {
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

//data: "cod_cliente="+cod_cliente+"&razon_social="+razon_social+
//"&nombre="+nombre+"&cif="+cif+"&direccion="+direccion+"&telefono="+telefono+
//"&email="+email+"&poblacion="+poblacion+"&provincia="+provincia+"&login="+login+"&pass="+pass+"&pass2="+pass2,

$var_cod_usuario = $_POST['cod_usuario'];

$var_usuario = htmlspecialchars($_POST['usuario'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_apellido = htmlspecialchars($_POST['apellido'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_login = htmlspecialchars($_POST['login'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_pass = htmlspecialchars($_POST['pass'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_pass2 = htmlspecialchars($_POST['pass2'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_cambiarpass = $_POST['cambiarpass'];
$var_activo = $_POST['activo'];

// $foto_plano = $_POST['foto_plano'];


if ($var_cod_usuario == "0") { // en el caso de ser 0, es un articulo nuevo y hay que obtener el codigo del nuevo articulo
	$var_cod_usuario = obtener_Cod("usuarios");

	$sql = "insert into usuarios (cod_usuario,usuario,login,pass,nombre,apellido,tipo,activo)
	values ('" . $var_cod_usuario . "','" . $var_usuario . "','" . $var_login . "',SHA1('" . $var_pass . "'),'" . $var_nombre . "','" . $var_apellido . "','1','" . $var_activo . "')";

} else { //

	$sql = "update usuarios set
	usuario='" . $var_usuario . "',
	login='" . $var_login . "',
	nombre='" . $var_nombre . "',
	apellido='" . $var_apellido . "',
	activo='" . $var_activo . "',
	tipo='1'";


	if ($var_cambiarpass == "true") {
		$sql = $sql . ", pass=SHA1('" . $var_pass . "') ";
	}
	$sql = $sql . " where cod_usuario='" . $var_cod_usuario . "'";
}

$conexion->query($sql);
echo $sql;