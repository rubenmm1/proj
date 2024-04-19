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

$var_cod_serie = $_POST['cod_serie'];

$var_codigo = htmlspecialchars($_POST['codigo'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_descripcion = htmlspecialchars($_POST['descripcion'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_cuenta = htmlspecialchars($_POST['cuenta_bancaria'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_p = htmlspecialchars($_POST['p'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_a = htmlspecialchars($_POST['a'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_f = htmlspecialchars($_POST['f'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_ab = htmlspecialchars($_POST['f'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_anio = htmlspecialchars($_POST['anio'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_activo = $_POST['activo'];


// $foto_plano = $_POST['foto_plano'];


if ($var_cod_serie == "0") { // en el caso de ser 0, es un articulo nuevo y hay que obtener el codigo del nuevo articulo
    $var_cod_serie = obtener_Cod("series");

    $sql = "insert into series (cod_serie,codigo,descripcion,cuenta_bancaria,p,a,f,ab,activo,anio)
	values ('" . $var_cod_serie . "','" . $var_codigo . "','" . $var_descripcion . "', '" . $var_cuenta . "','" . $var_p . "','" . $var_a . "','" . $var_f . "','" . $var_ab . "','" . $var_activo . "','" . $var_anio . "')";

} else { //

    $sql = "update series set
	codigo='" . $var_codigo . "',
	descripcion='" . $var_descripcion . "',
	cuenta_bancaria='" . $var_cuenta . "',
    p='" . $var_p . "',
    a='" . $var_a . "',
    f='" . $var_f . "',
	ab='" . $var_ab . "',
	activo='" . $var_activo . "',
	anio='" . $var_anio . "'";

    $sql = $sql . " where cod_serie='" . $var_cod_serie . "'";

}

$conexion->query($sql);
