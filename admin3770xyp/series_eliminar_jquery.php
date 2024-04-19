<?php
@session_start();
if (!isset ($_SESSION['cod_usuario'])) {
    header("location: index.php");
}

include ("../conexion.php");

$var_cod = htmlspecialchars($_POST['cod_serie'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
$sql = "update series set
activo=0
where cod_serie='" . $var_cod . "'";

$conexion->query($sql);

// echo $sql;