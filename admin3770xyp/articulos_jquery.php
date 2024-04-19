<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

//data: "cod_articulo="+cod_articulo+"&nombre="+nombre+"&descripcion="+descripcion+"&tipo="+tipo+"&activo="+activo+"&precio="+precio+"&imagen="+imagen,

$var_cod_articulo = htmlspecialchars($_POST['cod_articulo'], ENT_QUOTES | ENT_HTML401, 'UTF-8');

$var_nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_descripcion = htmlspecialchars($_POST['descripcion'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_tipo = htmlspecialchars($_POST['tipo'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_precio = htmlspecialchars($_POST['precio'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_foto =$_POST['foto'];
//echo $var_cod_articulo;


if ($var_cod_articulo=="0"){// en el caso de ser 0, es un articulo nuevo y hay que obtener el codigo del nuevo articulo
	$var_cod_articulo=obtener_Cod("articulos");
	$sql="insert into articulos (cod_articulo,nombre,descripcion,activo,tipo,precio)
	values ('".$var_cod_articulo."','".$var_nombre."','".$var_descripcion."','1',".$var_tipo.",'".$var_precio."')";

}else{//
	$sql="update articulos set
	nombre='".$var_nombre."',
	descripcion='".$var_descripcion."',
	tipo=".$var_tipo.",
	precio='".$var_precio."',
	tipo='".$var_tipo."'
	where cod_articulo='".$var_cod_articulo."'";
}

if($var_foto<>""){
	$arrayfoto=explode("\\",$var_foto);

	$path = "../fotos/".$var_cod_articulo;
	if (!is_dir($path)) {
	    mkdir($path, 0777, true);
	}
	copy("temp/".$arrayfoto[2], "../fotos/".$var_cod_articulo."/".$var_cod_articulo.".jpg" );
	unlink("temp/".$arrayfoto[2]);
}


$conexion->query($sql);
echo $sql;
?>
