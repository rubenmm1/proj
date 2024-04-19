<?php
@session_start();

$var_usuario = htmlspecialchars($_POST['usuario'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
//$var_usuario =$_POST['usuario'];
$var_pass = htmlentities($_POST['pass']);
//echo password_hash($var_pass, PASSWORD_DEFAULT);
include ("conexion.php");
//$consulta="SELECT * FROM usuarios_web where activo=1 and login LIKE '".$var_usuario."' and pass=SHA1('".$var_pass."')";
$consulta = "SELECT * from clientes where activo=1 and login LIKE '" . $var_usuario . "' and pass=SHA1('" . $var_pass . "')";
//echo $consulta;
$result = $conexion->query($consulta);
if ($result->num_rows == 0) {// Usuario web no existente
	echo 0;
} else {// existe el usuario web
	while ($fila1 = $result->fetch_assoc()) {

		$_SESSION['cod_cliente'] = $fila1['cod_cliente'];
		$_SESSION['razon_social'] = $fila1['razon_social'];
		$_SESSION['nombre'] = $fila1['nombre'];
		$_SESSION['cif'] = $fila1['cif'];
		$_SESSION['direccion'] = $fila1['direccion'];
		$_SESSION['cp'] = $fila1['cp'];
		$_SESSION['poblacion'] = $fila1['poblacion'];
		$_SESSION['provincia'] = $fila1['provincia'];
		echo 1;
	}
}
?>