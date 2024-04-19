<?php
@session_start();
if (!isset($_SESSION['cod_usuario'])) {
    header("location: index.php");
}

include("../conexion.php");

$cod_revision = $_GET['cod_revision'];

$sqlInci = 'SELECT * FROM incidencias WHERE id_revision=' . $cod_revision;
$resultInci = $conexion->query($sqlInci);
$incidenciasData = $resultInci->fetch_assoc();
$articulos = [];

if ($incidenciasData) {
    $cod_incidencia = $incidenciasData['cod_incidencia'];

    $sqlincidenciasLinea = 'SELECT * FROM incidencias_lineas WHERE id_incidencia=' . $cod_incidencia;
    $resultArticulos = $conexion->query($sqlincidenciasLinea);

    $articulosData = [];
    while ($row = $resultArticulos->fetch_assoc()) {
        $articulosData[] = $row;
    }

    foreach ($articulosData as &$articulo) {
        $id_articulo = $articulo['id_articulo'];
        $sqlArticuloDetails = 'SELECT * FROM articulos WHERE cod_articulo=' . $id_articulo;
        $resultArticuloDetails = $conexion->query($sqlArticuloDetails);
        $articuloDetails = $resultArticuloDetails->fetch_assoc();
        $articulo['articulo_details'] = $articuloDetails;
        array_push($articulos, $articuloDetails);
    }
} else {
    $articulos = [];
}

$conexion->close();
$data = array(
    'incidencias' => $incidenciasData,
    'articulosData' => $articulosData,
    'articulos' => $articulos
);

echo json_encode($data);
