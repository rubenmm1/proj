<?php
@session_start();
if (!isset($_SESSION['cod_usuario'])) {
    header("location: index.php");
}

include("../conexion.php");
$codigo_maquina = filter_input(INPUT_POST, 'cod_maquina');
$codigo_revision = filter_input(INPUT_POST, 'cod_revision');
$codigo_cliente = filter_input(INPUT_POST, 'cod_cliente');
$editar = filter_input(INPUT_POST, 'editar');
/*
 * En el caso de que sea una modificacion se cargan los datos
 */

$fecha = date("Y-m-d");
$cont_fotos = 1;
if ($editar == 1)
    $html_btn_annadir_foto = '<div class="col-3 d-flex justify-content-center align-items-center div_btn_camara p-5"><div class="col-md-auto btn_circular puntero" id="add_foto"><center><i class="fa fa-camera" aria-hidden="true"></i></center></div></div>';

if (!empty($codigo_revision)) { // Modificar revision

    /*
     * Obtener la información de la revision
     */
    $sql = "select * from revisiones where cod_revision=" . $codigo_revision;

    $resul = $conexion->query($sql);

    while ($fila = $resul->fetch_assoc()) {
        $descripcion = $fila['descripcion'];
        $fecha = $fila["fecha"];
        $firma = $fila["firma"];
        $fecha_firma = $fila["fecha_firma"];
        $cod_revision = $fila["cod_revision"];
    }

    $dateTime = new DateTime($fecha_firma);
    $date = $dateTime->format('d-m-Y');
    $hour = $dateTime->format('H:i:s');


    /*
     * En el caso de tener imagenes, mostrar las imagenes     * 
     */

    $fotos_guardadas = "";


    $sql = "select * from revisiones_fotos where id_revision=" . $codigo_revision;


    $resulF = $conexion->query($sql);
    while ($filaF = $resulF->fetch_assoc()) {

        if ($editar == 1) {
            $btn_elimnar_foto = '<div class="col-6 text-right btn_eliminar_foto puntero" nom_foto="' . $filaF['foto'] . '" cod_registro="' . $cont_fotos . '" cod_foto="' . $filaF['cod_revisiones_fotos'] . '" cod_revision="' . $codigo_revision . '" ><i class="fa fa-trash btn_eliminar puntero tx-danger" cod="4"></i></div>';
            $btn_desc_foto = '<input type="text"  class="form-control" id=txt_foto_' . $cont_fotos . ' value="' . $filaF['descripcion_foto'] . '" />';
            $btn_input_foto = '<input type="file" id=foto_' . $cont_fotos . '  class="fotos" val="' . $cont_fotos . '" data-max-file-size="3M" />   ';
        } else if ($editar == 0) {
            $btn_desc_foto = '<input type="text" disabled class="form-control" id=txt_foto_' . $cont_fotos . ' value="' . $filaF['descripcion_foto'] . '" />';

            $btn_eliminar_foto = "";
            $btn_input_foto = "";
        }

        $fotos_guardadas .= ' <div id="card-' . $cont_fotos . '" class="card col-md-3 col-sm-12 p-2"> 
                <div class=row>
                    <div class="col-6"><label for="id=txt_foto_' . $cont_fotos . '">Descripcion</label></div>
                    ' . $btn_eliminar_foto . '
                </div>                        
                ' . $btn_desc_foto . '
                <img id="card-img-top_' . $cont_fotos . '" src="./fotos/revisiones/' . $codigo_revision . '/' . $filaF['foto'] . '">
                ' . $btn_input_foto . '            
            </div>';
        $cont_fotos++;

    }

}
?>
<!DOCTYPE html>
<html lang="es">
<!--- Internal Select2 css-->
<link href="../assets/plugins/select2/css/select2.min.css" rel="stylesheet">

<!---Internal Fileupload css-->
<link href="../assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css" />
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

                <!-- Alert -->
                <div class="alert alert-warning" role="alert" id="alert_datos">
                    <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Faltan datos!</strong> Asegúrese de haber rellenado todos los datos.
                </div>
                <div class="row  ">
                    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 mx-auto">
                        <div class="card  box-shadow-0">

                            <div class="card-header"></div>

                            <div class="card-body pt-0">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <div class="col-6">
                                            <label class="form-label" for="fecha">Fecha</label>
                                            <input <?php echo $editar == 1 ? '' : 'disabled' ?> type="date"
                                                class="form-control" id="fecha" name="fecha"
                                                value="<?php echo $fecha; ?>">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="descripcion">Descripcion</label>
                                            <textarea <?php echo $editar == 1 ? '' : 'disabled' ?> class="form-control"
                                                name="descripcion" placeholder="Descripcion" id="descripcion"
                                                rows="5"><?php echo $descripcion; ?></textarea>
                                        </div>

                                        <input type="hidden" id='cod_revision' name="cod_revision"
                                            value="<?php echo $cod_revision; ?>">
                                    </div>
                                </form>

                                <div class="form-group mb-0 mt-3">
                                    <label class="form-label h3">Fotos</label>

                                    <div class="row" id="capa_imagenes">
                                        <!-- capa donde se irán cargando las fotos a subir -->
                                        <?php echo $fotos_guardadas; ?>
                                        <?php echo $html_btn_annadir_foto; ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row justify-content-center align-items-center g-2">
                                    <div class="col-12">
                                        <label class="form-label h3">Firma</label>
                                        <div class="col offset-md-12 d-flex justify-content-center">
                                            <?php
                                            if ($firma != null && trim($firma) != '') {
                                                echo '<img src="../firmas/revisiones/' . $firma . '" class="img-fluid rounded-top" alt="">';

                                            } else {
                                                echo '<canvas class="border mt-3" id="firma_cliente"></canvas>';
                                            }
                                            ?>
                                        </div>

                                    </div>
                                    <?php
                                    if ($firma != null && trim($firma) != '')
                                        echo '<small class="col-3 tx-center">Firmado el ' . $date . ' a las ' . $hour . '</small>';
                                    ?>
                                    <?php
                                    if ($firma == null) {

                                        echo '<button class="col-1 btn btn-danger" id="btnLimpiar">Borrar</button>';
                                    }
                                    ?>

                                </div>
                                <div class="form-group mb-0 mt-5 text-center">
                                    <div>
                                        <form action="revisiones.php" method="post"><!-- comment -->
                                            <input type="hidden" name="cod_maquina" id="cod_maquina"
                                                value='<?php echo $codigo_maquina; ?>' />
                                            <input type="hidden" name="cod_cliente" id="cod_cliente"
                                                value='<?php echo $codigo_cliente; ?>' />
                                            <?php
                                            if ($firma == null)
                                                echo '<div id="btn-guardar" class="btn btn-primary">Guardar</div>';
                                            ?>

                                            <input type="submit" id="btn_volver" class="btn btn-secondary"
                                                value="Volver">
                                            <div id='msn'>
                                            </div>
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
    <script src="../assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Bundle js -->
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Ionicons js -->
    <script src="../assets/plugins/ionicons/ionicons.js"></script>

    <!-- Moment js -->
    <script src="../assets/plugins/moment/moment.js"></script>

    <!-- P-scroll js -->
    <script src="../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/plugins/perfect-scrollbar/p-scroll.js"></script>

    <!-- Rating js-->
    <script src="../assets/plugins/rating/jquery.rating-stars.js"></script>
    <script src="../assets/plugins/rating/jquery.barrating.js"></script>

    <!-- Custom Scroll bar Js-->
    <script src="../assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Horizontalmenu js-->
    <script src="../assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>

    <!-- Sticky js -->
    <script src="../assets/js/sticky.js"></script>

    <!-- Right-sidebar js -->
    <script src="../assets/plugins/sidebar/sidebar.js"></script>
    <script src="../assets/plugins/sidebar/sidebar-custom.js"></script>

    <!-- eva-icons js -->
    <script src="../assets/js/eva-icons.min.js"></script>

    <!--Internal Fileuploads js-->
    <script src="../assets/plugins/fileuploads/js/fileupload.js"></script>
    <script src="../assets/plugins/fileuploads/js/file-upload.js"></script>

    <!--Internal Fancy uploader js-->
    <script src="../assets/plugins/fancyuploder/jquery.ui.widget.js"></script>
    <script src="../assets/plugins/fancyuploder/jquery.fileupload.js"></script>
    <script src="../assets/plugins/fancyuploder/jquery.iframe-transport.js"></script>
    <script src="../assets/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
    <script src="../assets/plugins/fancyuploder/fancy-uploader.js"></script>


    <!-- custom js -->
    <script src="../assets/js/custom.js"></script>

    <!-- Firma -->
    <script src="../assets/js/manually_signature.js"></script>

    <script>

        var cont_fotos = <?php echo $cont_fotos; ?>;



        $("#btn-guardar").on("click", function () {
            arrayfotos = [];
            descripcion = $("#descripcion").val().trim();
            cod_maquina = <?php echo $codigo_maquina; ?>;
            cod_usuario = <?php echo $_SESSION['cod_usuario']; ?>;

            fecha = $("#fecha").val();
            cod_revision = $("#cod_revision").val();
            // console.log(descripcion);

            if (fecha == '' || descripcion == '') {
                $('#alert_datos').removeAttr('id');
            } else {
                for (i = 1; i < cont_fotos; i++) {

                    /*obj_img = "#foto_" + i;*/
                    obj_img = "#card-img-top_" + i;
                    obj_txt = "#txt_foto_" + i;

                    /*ruta_foto_aux = $(obj_img).val();*/
                    ruta_foto_aux = $(obj_img).attr("src");
                    if (ruta_foto_aux != undefined) {
                        array_nom_foto = ruta_foto_aux.split("/");
                        arrayaux = [array_nom_foto[array_nom_foto.length - 1], $(obj_txt).val()];

                        arrayfotos.push(arrayaux);
                    }

                }

                var valParam = JSON.stringify(arrayfotos);
                // console.log(valParam);

                $.ajax({
                    url: 'add_foto_revision_jquery.php',
                    type: 'post',
                    data: "cod_maquina=" + cod_maquina + "&cod_usuario=" + cod_usuario + "&descripcion=" + descripcion + "&cod_revision=" + cod_revision + "&fecha=" + fecha + "&fotos=" + valParam,
                    beforeSend: function () {
                        $("#msn").html('<div class="text-center col-md-12 m-5"><div class="spinner-border avatar-lg text-primary m-2" role="status"></div></div>');
                    },
                    success: function (response) {
                        $("#msn").html('');
                        // console.log(response);

                        if (response == 0) {
                            // if (!empty) {
                            guardarFirma($("#descripcion").val().trim().replace(' ', '_') + ".png", cod_revision);
                            $("#btn_volver").trigger('click');

                        } else {
                            alert(response);
                        }
                    }
                });
            }





        });

        $(document).on('change', '.fotos', function () {
            var id = $(this).attr("val");
            var formData = new FormData();
            var files = $(this)[0].files[0];
            formData.append('file', files);
            $.ajax({
                url: 'upload.php',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response != 0) {
                        $("#card-img-top_" + id).attr("src", response);
                    } else {
                        alert('Formato de imagen incorrecto.');
                    }
                }
            });
            return false;
        });


        $(document).on('click', '#add_foto', function () {
            $(".div_btn_camara").remove();
            $('#capa_imagenes').append('<div id="card-' + cont_fotos + '" class="col-md-3 col-sm-12 card p-1"> \n\
                            <div class=row>\n\
                                    <div class="col-6"><label for="id=txt_foto_'+ cont_fotos + '">Descripcion</label></div>\n\
                                    <div class="col-6 text-right btn_eliminar_foto puntero" nom_foto="" cod_revision="" cod_registro="'+ cont_fotos + '" cod_foto="" ><i class="fa fa-trash btn_eliminar puntero tx-danger" cod="4"></i></div>\n\
                                </div>\n\
                                <input type="text"  class="form-control" id=txt_foto_' + cont_fotos + ' />\n\
                                <img id="card-img-top_' + cont_fotos + '" src="../assets/img/default_image.jpg">\n\
                                <input type="file" id=foto_' + cont_fotos + '  class="fotos" val="' + cont_fotos + '" data-max-file-size="3M" />\n\
                            </div><?php echo $html_btn_annadir_foto; ?>');

            cont_fotos++;
        });

        $(document).on('click', '.btn_eliminar_foto', function () {

            cod_registro = $(this).attr("cod_registro");
            cod_foto = $(this).attr("cod_foto");

            cod_revision = $(this).attr("cod_revision");


            if (confirm("Se eliminará definitivamente la foto, deseas eliminar?")) {

                if (cod_foto === "") {// ficha nueva

                    /*
                     * Obtengo el nombre del fichero subido. 
                     */

                    obj_img = "#card-img-top_" + cod_registro;
                    ruta_foto_aux = $(obj_img).attr("src");
                    array_nom_foto = ruta_foto_aux.split("/");
                    nom_foto = array_nom_foto[array_nom_foto.length - 1];


                } else {// ficha cargada de las fotos
                    nom_foto = $(this).attr("nom_foto");
                }

                $.ajax({
                    url: 'del_foto_revision_jquery.php',
                    type: 'post',
                    data: "cod_foto=" + cod_foto + "&nombre_foto=" + nom_foto + "&cod_revision=" + cod_revision,
                    beforeSend: function () {
                    },
                    success: function (response) {
                        //$("#msn").html(response);                            
                        $("#card-" + cod_registro).remove();
                    }
                });

            }

        });
    </script>
</body>

</html>