<?php
@session_start();

$var_usuario = htmlspecialchars($_POST['usuario'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
//$var_usuario =$_POST['usuario'];
$var_pass = htmlentities($_POST['pass']);
//echo password_hash($var_pass, PASSWORD_DEFAULT);
include ("../conexion.php");
//$consulta="SELECT * FROM usuarios_web where activo=1 and login LIKE '".$var_usuario."' and pass=SHA1('".$var_pass."')";
$consulta = "SELECT * from usuarios where activo=1 and login LIKE '" . $var_usuario . "' and pass=SHA1('" . $var_pass . "')";
// echo $consulta;
$result = $conexion->query($consulta);
if ($result->num_rows == 0) {// Usuario web no existente
	echo "-1";
} else {// existe el usuario web
	while ($fila1 = $result->fetch_assoc()) {

		$_SESSION['cod_usuario'] = $fila1['cod_usuario'];
		$_SESSION['usuario'] = $fila1['usuario'];
		$_SESSION['nombre'] = $fila1['nombre'];
		$_SESSION['apellido'] = $fila1['apellido'];
		$_SESSION['tipo'] = $fila1['tipo'];
		echo $_SESSION['tipo'];
	}
}
?>