<?php

@session_start();
if (!isset($_SESSION['cod_usuario'])) {
    header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

$var_id_revision = filter_input(INPUT_POST, "id_revision");
$var_cod_cliente = filter_input(INPUT_POST, "cod_cliente");
$var_descripcion = htmlspecialchars(filter_input(INPUT_POST, "descripcion"), ENT_QUOTES | ENT_HTML401, 'UTF-8');
$var_array_fotos = json_decode(filter_input(INPUT_POST, "fotos"));
$var_array_articulos = json_decode(filter_input(INPUT_POST, "articulos"));

/*
 *  Creo o modifico la cabecera de la incidencia
 * 
 */

$sql="select cod_incidencia from incidencias where id_revision=".$var_id_revision;        
$result = $conexion->query($sql);

if(!$result->num_rows){
    $cod_incidencia = obtener_Cod('incidencias');
    $sql_in = "INSERT INTO incidencias (cod_incidencia,id_revision,id_cliente,fecha,descripcion) VALUES"
            . "(".$cod_incidencia.",".$var_id_revision.",".$var_cod_cliente.",NOW(),'".$var_descripcion."')";
}else{

    $cod_incidencia = $result->fetch_assoc()['cod_incidencia'];

    $sql_in = "UPDATE incidencias set descripcion='".$var_descripcion."' where cod_incidencia=".$cod_incidencia;

}
// echo $sql_in;
    $conexion->query($sql_in);


/*
 * Guardar las fotos, si se han subido alguna
 * 
 */

// echo "FOTOS<br>";

// Borro todas las fotos 
$sqlBorrarFotos = "delete from incidencias_fotos where id_incidencia=" . $cod_incidencia;
$conexion->query($sqlBorrarFotos);
foreach ($var_array_fotos as $foto) {

    //[0]=>nombre_imagen
    //[1]=>texto_descriptivo_imagen

    if ($foto[0] <> "default_image.jpg" ) {

        // Creacion del sql para insertar    
        $sql = "insert into incidencias_fotos (id_incidencia,foto,descripcion_foto) values (" . $cod_incidencia . ",'" . $foto[0] . "','" . $foto[1] . "')";
        
        $path_fotos = "fotos/incidencias/" . $cod_incidencia;
        if (!file_exists($path_fotos)) {            
            mkdir($path_fotos, 0777, true);
        }

        /*
         * La manera de comprobar de que es una foto ya subido
         */
        echo $foto[0];
        if (file_exists("temp/" . $foto[0])) {
            copy("temp/" . $foto[0], $path_fotos . "/" . $foto[0]);
            unlink("temp/" . $foto[0]);
        }

        $conexion->query($sql);

    }
}
// echo 'ervcw';

/*
 * Añado las lineas de la incidencia
 * 
 */
// var_dump($var_array_articulos);
// Borro las lineas de la incidencia
$sqlBorrarLineas = 'delete from incidencias_lineas where id_incidencia='.$cod_incidencia;
$conexion->query($sqlBorrarLineas);
// echo $conexion->error;
foreach ($var_array_articulos as $articulo) {
    // var_dump($articulo);
        
    $sql_in_l = "insert into incidencias_lineas (id_incidencia,id_articulo,cantidad,descripcion) values "
            . "(".$cod_incidencia.",'".$articulo[0]."',".$articulo[1].",'".$articulo[2]."')";    
    
   // echo $articulo[0]." ".$articulo[1]." ".$articulo[2]." ".$articulo[3]."<br>";
    // echo $sql_in_l;
    $conexion->query($sql_in_l);
    
   
}



//
//
//if (empty($var_cod_incidencia)) {/// en el caso de ser una actualizacion, no se añade la revision, sino que se actualizará
//    $var_cod_revision = obtener_Cod("incidencias");
//    $sqlRevision = "INSERT INTO incidencias (cod_incidencia,id_maquina,id_usuario,fecha,descripcion) "
//            . "values (" . $var_cod_revision . "," . $var_cod_maquina . "," . $var_cod_usuario . ",NOW(),'" . $var_descripcion . "');";
//} else {
//    $sqlRevision = "UPDATE incidencias set fecha='" . $var_fecha . "',descripcion='" . $var_descripcion . "' where cod_incidencia=" . $var_cod_revision;
//}
//
//$conexion->query($sqlRevision);
//
///*
// * Elimino todos las fotos actuales de esta revision, para luego añadir todas. De esta manera evito el tener que comprobar que es una actualizacion
// */
//
//$sqlDelete = "delete from incidencias_fotos where id_incidencia=" . $var_cod_revision;
//$conexion->query($sqlDelete);
//
//
//foreach ($var_array_fotos as $foto) {
//
//    //[0]=>nombre_imagen
//    //[1]=>texto_descriptivo_imagen
//
//    if ($foto[0] <> "default_image.jpg" && $foto[1] <> "") {
//
//        // Creacion del sql para insertar    
//        $sql = "insert into incidencias_fotos (id_incidencia,foto,descripcion_foto) values (" . $var_cod_incidencia . ",'" . $foto[0] . "','" . $foto[1] . "')";
//
//        // Mover la imagen de la carpeta temporal(temp)
//
//        $path_fotos_maquina = "fotos/revisiones/" . $var_cod_revision;
//        if (!file_exists($path_fotos_maquina)) {            
//            mkdir($path_fotos_maquina, 0777, true);
//        }
//
//        /*
//         * La manera de comprobar de que es una foto ya subido
//         */
//
//        if (file_exists("temp/" . $foto[0])) {
//            copy("temp/" . $foto[0], $path_fotos_maquina . "/" . $foto[0]);
//            unlink("temp/" . $foto[0]);
//        }
//
//        $conexion->query($sql);
//    }
//}
?>