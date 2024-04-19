<?php

$codigo_revision = $_GET['rev'];
$codigo_incidencia = $_GET['inc'];
$codigo_maquina = $_GET['maq'];
@session_start();
if (!isset($_GET['inc'])) {
    header("location: maquina.php");
}

include("conexion.php");
/*
 * En el caso de que sea una modificacion se cargan los datos
 */

$fecha = date("Y-m-d");
$cont_fotos = 1;
/*
 * Obtener la información de la incidencia
 */
$sql = "select * from incidencias where cod_incidencia=" . $codigo_incidencia;
// var_dump($sql);

$resul = $conexion->query($sql);

while ($fila = $resul->fetch_assoc()) {
    $descripcion = $fila['descripcion'];
    $fecha = $fila["fecha"];
    $codigo_incidencia = $fila["cod_incidencia"];
    $codigo_revision = $fila["id_revision"];
}

/////Obtengo la descripcion de la revision correspondiente a la incidencia

$sqlDes="select descripcion as des from revisiones where cod_revision=".$codigo_revision;
$descripcionRev=$conexion->query($sqlDes)->fetch_assoc()['des'];


//////////// Obtengo las líneas de la incidencia
$sqlLineas = "SELECT incidencias_lineas.id_articulo, incidencias_lineas.cantidad, incidencias_lineas.descripcion,articulos.nombre  from incidencias_lineas inner join articulos on cod_articulo=id_articulo where id_incidencia=" . $codigo_incidencia;
// var_dump($sqlLineas);

$resulLineas = $conexion->query($sqlLineas);

$array_lineas = array();
if (!$conexion->error) {



    while ($filaLinea = $resulLineas->fetch_assoc()) {
        $array_dato = array();
        $array_dato['id_articulo'] = $filaLinea['id_articulo'];
        $array_dato['descripcion'] = $filaLinea['descripcion'];
        $array_dato['cantidad'] = $filaLinea['cantidad'];
        $array_dato['nombre'] = $filaLinea['nombre'];

        array_push($array_lineas, $array_dato);
    }
    // var_dump($array_lineas);

}
/*
 * En el caso de tener imagenes, mostrar las imagenes     * 
 */

$fotos_guardadas = "";

if (!$codigo_incidencia)
    $where = '';
else
    $where = "where id_incidencia=" . $codigo_incidencia;

$sql = "select * from incidencias_fotos " . $where;

$resulF = $conexion->query($sql);
while ($filaF = $resulF->fetch_assoc()) {

    $fotos_guardadas .= ' <div id="card-' . $cont_fotos . '" class="card col-md-6 col-sm-12 p-2"> 
                <div class=row>
                    <div class="col-6"><label for="id=txt_foto_' . $cont_fotos . '">Descripcion</label></div>
                    <div class="col-6 text-right btn_eliminar_foto puntero" nom_foto="' . $filaF['foto'] . '" cod_registro="' . $cont_fotos . '" cod_foto="' . $filaF['cod_incidencias_fotos'] . '" cod_incidencia="' . $codigo_incidencia . '" ><i class="fa fa-trash btn_eliminar puntero tx-danger" cod="4"></i></div>
                </div>                        
                <input type="text"  class="form-control" id=txt_foto_' . $cont_fotos . ' value="' . $filaF['descripcion_foto'] . '" />
                <img id="card-img-top_' . $cont_fotos . '" src="./fotos/incidencias/' . $codigo_incidencia . '/' . $filaF['foto'] . '">
                <input type="file" id=foto_' . $cont_fotos . '  class="fotos" val="' . $cont_fotos . '" data-max-file-size="3M" />               
            </div>';
    $cont_fotos++;
}
// }
?>
<!DOCTYPE html>
<html lang="es">
<!--- Internal Select2 css-->
<link href="./assets/plugins/select2/css/select2.min.css" rel="stylesheet">

<!---Internal Fileupload css-->
<link href="./assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css" />
<?php
include("head.php");
?>

<body class="main-body">
    <!-- Loader -->
    <?php
    include("loader.php");
    ?>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

        <!-- main-header opened -->
        <?php
        include("main-header.php");
        ?>
        <!-- /main-header -->

        <!-- centerlogo-header opened -->
        <?php
        include("centerlogo-header.php");
        ?>
        <!-- /centerlogo-header closed -->

        <!--Horizontal-main -->
        <?php
        include("horizontal-main.php");
        ?>
        <!--Horizontal-main -->

        <!-- main-content opened -->
        <div class="main-content horizontal-content">

            <!-- container opened -->
            <div class="container">

                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="my-auto">
                        <div class="d-flex">
                            <h4 class="content-title mb-0 my-auto">Clientes</a><span
                                    class="text-muted mt-1 tx-13 ms-2 mb-0">/ <span
                                        class='content-title mb-0 my-auto h5'>Maquinas asociadas</span> / <span
                                        class='content-title mb-0 my-auto h5'>Revisiones</span> / Incidencia
                        </div>
                    </div>
                </div>
                <!-- breadcrumb -->

                <div class="row  ">
                    <div class="col-lg-8 col-8-12 col-md-8 col-sm-12 mx-auto">
                        <div class="card  box-shadow-0">

                            <div class="card-header">

                                <h3>Datos de la incidencia</h3>
                                <h4>Revision correspondiente: </h4>
                                <p><?php echo $descripcionRev?></p>
                            </div>
                            <div class="card-body pt-0">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label class="form-label" for="fecha">Fecha</label>
                                        <input disabled type="date" class="form-control" id="fecha" name="fecha"
                                            value="<?php echo $fecha; ?>">
                                        <label class="form-label" for="descripcion">Descripcion</label>
                                        <textarea disabled class="form-control" name="descripcion"
                                            placeholder="Descripcion" id="descripcion"
                                            rows="3"><?php echo $descripcion; ?></textarea>
                                        <input type="hidden" id='cod_incidencia' name="cod_incidencia"
                                            value="<?php echo $codigo_incidencia; ?>">
                                    </div>
                                </form>
                                <hr>
                                <!-- <div class="form-group mb-0 mt-3 "> -->
                                <label class="form-label h3">Articulos</label>
                                <div class="row">


                                    <div class="col-12 pt-3">
                                        <div class="table-responsive hoverable-table">

                                            <table id="tabla_listado" class="table text-md-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th data-orderable="false">Articulo</th>
                                                        <th data-orderable="false">Cantidad</th>
                                                        <th data-orderable="false">Descripcion</th>
                                                        <th data-orderable="false"></th>
                                                        <th data-orderable="false"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="body_table">
                                                    <!-- PINTO LAS LINEAS DE LA INCIDENCIA -->
                                                    <?php

                                                    foreach ($array_lineas as $linea) {

                                                        echo "<tr>
                                                                                    <td>" . $linea['nombre'] . "</td>
                                                                                    <td>" . $linea['cantidad'] . "</td>
                                                                                    <td>" . $linea['descripcion'] . "</td>
                                                                                    <td class='btn_modificar' desc = '" . $linea['descripcion'] . "' cod_articulo = '" . $linea['id_articulo'] . "' nombre_articulo = '" . $linea['nombre'] . "' cantidad='" . $linea['cantidad'] . "'><i class='fa fa-edit'></i></td>
                                                                                    <td class='btn_borrar'><i class='far fa-trash-alt'></i></td></tr>";

                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                </div>

                                <!-- </div> -->
                                <hr>
                                <div class="form-group mb-0 mt-3">
                                    <label class="form-label h3">Fotos</label>

                                    <div class="row" id="capa_imagenes">
                                        <!-- capa donde se irán cargando las fotos a subir -->
                                        <?php echo $fotos_guardadas; ?>
                                        <!-- <?php echo $html_btn_annadir_foto; ?> -->
                                    </div>

                                </div>


                                <div class="form-group mb-0 mt-5 text-center">

                                    <div>
                                        <form action="maquina.php" method="post"><!-- comment -->
                                            <input type="hidden" name="txt_cod_maquina" id="cod_maquina"
                                                value='<?php echo $codigo_maquina; ?>' />
                                            <!-- <input type="hidden" name="cod_cliente" id="cod_cliente" value='<?php echo $codigo_cliente; ?>' />                                                         -->
                                            <!-- <div id="btn-guardar" class="btn btn-primary">Guardar</div> -->
                                            <input type="submit" id="btn_volver" class="btn btn-secondary"
                                                value="Volver">
                                            <div id='msn'></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
            <!-- Container closed -->
        </div>
        <!-- main-content closed -->

        <!-- Sidebar-right-->
        <?php
        //include("sidebar.php");
        ?>
        <!--/Sidebar-right-->

        <!-- Footer opened -->
        <?php
        include("footer.php");
        ?>
        <!-- Footer closed -->

    </div>
    <!-- End Page -->

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

    <!-- JQuery min js -->
    <script src="./assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Bundle js -->
    <script src="./assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Ionicons js -->
    <script src="./assets/plugins/ionicons/ionicons.js"></script>

    <!-- Moment js -->
    <script src="./assets/plugins/moment/moment.js"></script>

    <!-- P-scroll js -->
    <script src="./assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="./assets/plugins/perfect-scrollbar/p-scroll.js"></script>

    <!-- Rating js-->
    <script src="./assets/plugins/rating/jquery.rating-stars.js"></script>
    <script src="./assets/plugins/rating/jquery.barrating.js"></script>

    <!-- Custom Scroll bar Js-->
    <script src="./assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Horizontalmenu js-->
    <script src="./assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>

    <!-- Sticky js -->
    <script src="./assets/js/sticky.js"></script>

    <!-- Right-sidebar js -->
    <script src="./assets/plugins/sidebar/sidebar.js"></script>
    <script src="./assets/plugins/sidebar/sidebar-custom.js"></script>

    <!-- eva-icons js -->
    <script src="./assets/js/eva-icons.min.js"></script>

    <!--Internal Fileuploads js-->
    <script src="./assets/plugins/fileuploads/js/fileupload.js"></script>
    <script src="./assets/plugins/fileuploads/js/file-upload.js"></script>

    <!--Internal Fancy uploader js-->
    <script src="./assets/plugins/fancyuploder/jquery.fileupload.js"></script>
    <script src="./assets/plugins/fancyuploder/jquery.iframe-transport.js"></script>
    <script src="./assets/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
    <script src="./assets/plugins/fancyuploder/jquery.ui.widget.js"></script>
    <script src="./assets/plugins/fancyuploder/fancy-uploader.js"></script>


    <!-- custom js -->
    <script src="./assets/js/custom.js"></script>


</body>

</html>