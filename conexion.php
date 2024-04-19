<?php
$servidor = "localhost:3307";
$user = "root";
$pwd = "Npyme2004";
$basedatos = "d3idi";


$conexion = new mysqli($servidor, $user, $pwd, $basedatos);
if ($error = mysqli_connect_errno()) {
	echo "Error de conexi&oacute;n con la base de datos<br>";
	echo "ERROR: $error";
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; url=error.php'>";
	exit;
}