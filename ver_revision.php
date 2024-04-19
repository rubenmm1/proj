<?php
$codigo_revision = $_GET['rev'];
$codigo_maquina = $_GET['maq'];

@session_start();
if (!isset($_GET['rev'])) {
    header("location: maquina.php");
}

include("conexion.php");

/*
 * En el caso de que sea una modificacion se cargan los datos
 */

$fecha = date("Y-m-d");
$cont_fotos = 1;
// $html_btn_annadir_foto='<div class="col-3 d-flex justify-content-center align-items-center div_btn_camara p-5"><div class="col-md-auto btn_circular puntero" id="add_foto"><center><i class="fa fa-camera" aria-hidden="true"></i></center></div></div>';

if (!empty($codigo_revision)) { // Ver revision

    /*
     * Obtener la información de la revision
     */
    $sql = "select * from revisiones where cod_revision=" . $codigo_revision;

    $resul = $conexion->query($sql);

    while ($fila = $resul->fetch_assoc()) {
        $descripcion = $fila['descripcion'];
        $fecha = $fila["fecha"];
        $cod_revision = $fila["cod_revision"];
        $firma = $fila["firma"];
        $fecha_firma = $fila["fecha_firma"];
    }

    /*
     * En el caso de tener imagenes, mostrar las imagenes     * 
     */

    $fotos_guardadas = "";


    $sql = "select * from revisiones_fotos where id_revision=" . $codigo_revision;

    $resulF = $conexion->query($sql);
    while ($filaF = $resulF->fetch_assoc()) {

        $fotos_guardadas .= ' <div id="card-' . $cont_fotos . '" class="card col-md-3 col-sm-12 p-2"> 
                <div class=row>
                    <div class="col-6"><label for="id=txt_foto_' . $cont_fotos . '">Descripcion</label></div>
                    
                </div>                        
                <input type="text" disabled  class="form-control" id=txt_foto_' . $cont_fotos . ' value="' . $filaF['descripcion_foto'] . '" />
                <img id="card-img-top_' . $cont_fotos . '" src="admin3770xyp/fotos/revisiones/' . $codigo_revision . '/' . $filaF['foto'] . '">
                      
            </div>';
        $cont_fotos++;

    }

}
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
                                        class='content-title mb-0 my-auto h5'>Revisiones</span> /
                                    <?php echo $descripcion; ?>
                        </div>
                    </div>
                </div>
                <!-- breadcrumb -->


                <div class="row  ">
                    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 mx-auto">
                        <div class="card  box-shadow-0">

                            <div class="card-header">
                                <h3>Datos de la revisión</h3>
                            </div>


                            <div class="card-body pt-0">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label class="form-label" for="fecha">Fecha</label>
                                        <input type="date" disabled class="form-control" id="fecha" name="fecha"
                                            value="<?php echo $fecha; ?>">
                                        <label class="form-label" for="descripcion">Descripcion</label>
                                        <textarea class="form-control" disabled name="descripcion"
                                            placeholder="Descripcion" id="descripcion"
                                            rows="5"><?php echo $descripcion; ?></textarea>
                                        <input type="hidden" id='cod_revision' name="cod_revision"
                                            value="<?php echo $cod_revision; ?>">
                                    </div>
                                </form>

                                <div class="form-group mb-0 mt-3">
                                    <label class="form-label h3">Fotos</label>

                                    <div class="row" id="capa_imagenes">
                                        <!-- capa donde se irán cargando las fotos a subir -->
                                        <?php echo $fotos_guardadas; ?>

                                    </div>

                                </div>
                                <?php
                                if ($firma != null && trim($firma) != '') { ?>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col-12">
                                            <label class="form-label h3">Firma</label>
                                            <div class="col offset-md-12 d-flex justify-content-center">
                                                <img src="firmas/revisiones/<?php echo $firma?>" class="img-fluid rounded-top"
                                                    alt="firma_cliente">
                                            </div>
                                        </div>
                                            <small class="col-3 tx-center">Firmado el <?php $date = new DateTime($fecha_firma);echo  $date->format('d-m-Y').' a las '.$date->format('H:i:s')?></small>
                                        </div>
                                <?php } ?>
                                <div class="form-group mb-0 mt-5 text-center">

                                    <form action="maquina.php" method="post">
                                        <input type="hidden" value="<?php echo $codigo_maquina ?>"
                                            name="txt_cod_maquina">
                                        <input type="submit" id="btn_volver" cod_maquina="" class="btn btn-secondary"
                                            value="Volver">
                                    </form>



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
    <script src="./assets/plugins/fancyuploder/jquery.ui.widget.js"></script>
    <script src="./assets/plugins/fancyuploder/jquery.fileupload.js"></script>
    <script src="./assets/plugins/fancyuploder/jquery.iframe-transport.js"></script>
    <script src="./assets/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
    <script src="./assets/plugins/fancyuploder/fancy-uploader.js"></script>


    <!-- custom js -->
    <script src="./assets/js/custom.js"></script>


</body>

</html>