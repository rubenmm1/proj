<?php
require_once('../conexion.php');
include("../functions.php");

// Store the signature img on folder
$data = file_get_contents("php://input");
$data = json_decode($data, true);

$var_cod_revision = $data['cod_rev'];

if (empty($var_cod_revision)) {
    $var_cod_revision = current_cod("revisiones");
}

$var_firma_name = $var_cod_revision . ".png";

$filteredData = substr($data['url'], strpos($data['url'], ",") + 1);
$decodedData = base64_decode($filteredData);

$fp = fopen('../firmas/revisiones/' . $var_firma_name, 'wb');
$ok = fwrite($fp, $decodedData);
fclose($fp);

// Update database
$date = new DateTime();
$sql = "UPDATE revisiones set firma = '" . $var_firma_name . "', fecha_firma = '" . $date->format('Y-m-d H:i:s') . "' WHERE cod_revision = " . $var_cod_revision;
$conexion->query($sql);
var_dump($sql);

if (!$conexion->error)
    echo "success";
return;
