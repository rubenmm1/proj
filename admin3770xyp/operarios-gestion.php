<?php
@session_start();
if (!isset ($_SESSION['cod_usuario'])) {
    header("location: index.php");
}

include ("../conexion.php");

if (!isset ($_POST['cod_usuario'])) { // añadir nuevo articulo

    $cod_usuario_mod = 0;
    $nombre = "";
    $usuario = "";
    $login = "";
    $password = "";
    $apellido = "";
    $tipo = 1;
    $activo = 1;

} else { // Modificamos el articulo
    $cod_usuario_mod = $_POST['cod_usuario'];

    $sql = "select * from usuarios where cod_usuario=" . $cod_usuario_mod;
    $result = $conexion->query($sql);

    while ($fila1 = $result->fetch_assoc()) {


        $nombre = $fila1['nombre'];
        $usuario = $fila1['usuario'];
        $login = $fila1['login'];
        $password = $fila1['pass'];
        $apellido = $fila1['apellido'];
        $tipo = $fila1['tipo'];
        $activo = $fila1['activo'];
    }

}
?>
<!DOCTYPE html>
<html lang="es">
<!--- Internal Select2 css-->
<link href="../assets/plugins/select2/css/select2.min.css" rel="stylesheet">
<!-- Internal Data table css -->
<link href="../assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="../assets/plugins/datatable/css/buttons.bootstrap5.min.css" rel="stylesheet">
<link href="../assets/plugins/datatable/responsive.bootstrap5.css" rel="stylesheet" />
<link href="../assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="../assets/plugins/datatable/responsive.dataTables.min.css" rel="stylesheet">

<!---Internal Fileupload css-->
<link href="../assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css" />
<?php
include ("head.php");
?>

<body class="main-body">
    <!-- Loader -->
    <?php
    include ("loader.php");
    ?>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

        <!-- main-header opened -->
        <?php
        include ("main-header.php");
        ?>
        <!-- /main-header -->

        <!-- centerlogo-header opened -->
        <?php
        include ("centerlogo-header.php");
        ?>
        <!-- /centerlogo-header closed -->

        <!--Horizontal-main -->
        <?php
        include ("horizontal-main.php");
        ?>
        <!--Horizontal-main -->

        <!-- main-content opened -->
        <div class="main-content horizontal-content">

            <!-- container opened -->
            <div class="container">

                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="my-auto">
                        <div class="d-flex"><a href='clientes.php'>
                                <h4 class="content-title mb-0 my-auto">Operarios</h4>
                            </a><span class="text-muted mt-1 tx-13 ms-2 mb-0">
                            </span></div>
                    </div>
                </div>
                <?php
                if ($_SESSION['tipo'] == 0) {
                    ?>

                    <div class="alert alert-warning" id="alert" style="display:none" role="alert">
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Revisa los campos!</strong> Revisa que todos los campos obligatorios han sido correctamente
                        rellenos.
                    </div>
                    <div class="alert alert-warning" id="alertContraseña" style="display:none" role="alert">
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Contraseña incorrecta!</strong> Revisa que las contraseñas coincidan.
                    </div>
                    <div class="row  ">
                        <div class="col-12">
                            <div class="card  box-shadow-0">
                                <div class="card-header">
                                </div>
                                <div class="card-body pt-0">
                                    <form action="post" class="form-horizontal" enctype="multipart/form-data">
                                        <div class='row'>
                                            <div class='col-12'>
                                                <h4>Introduzca los Datos</h4>
                                            </div>
                                            <div class='col-md-4 pt-2'>
                                                <label class="form-label">Usuario<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" required id="usuario" placeholder=""
                                                    value='<?php echo $usuario; ?>'>
                                            </div>

                                            <div class='col-md-4 pt-2'>
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" placeholder=""
                                                    value='<?php echo $nombre; ?>'>
                                            </div>

                                            <div class='col-md-4 pt-2'>
                                                <label class="form-label">Apellidos <span
                                                        class="text-danger"></span></label>
                                                <input type="text" class="form-control" id="apellido" placeholder=""
                                                    value='<?php echo $apellido; ?>'>
                                            </div>



                                            <div class='col-md-5 pt-2'>
                                                <label class="form-label">Login <span class="text-danger">*</span></label>
                                                <input type="text" required class="form-control" id="login" placeholder=""
                                                    value='<?php echo $login; ?>'>
                                            </div>


                                            <div class='col-md-5 pt-2'>
                                                <label class="form-label">Contraseña <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" required class="form-control" id="pass" placeholder=""
                                                    value=''>
                                            </div>

                                            <div class='col-md-5 pt-2'>
                                                <label class="form-label">Repetir Contraseña <span
                                                        class="text-danger"></span></label>
                                                <input type="text" required class="form-control" id="pass2" placeholder=""
                                                    value=''>
                                            </div>

                                            <div class='col-md-2 pt-2 mt-4'>
                                                <input type="checkbox" checked
                                                    id="activo" ">
                                                                                                                    <label>activo</label>
                                                                                                                </div>


                                                                                                                <!-- <option value=" null">
                                            </option>
                                            -->
                                                </select>
                                            </div>
                                        </div>
                                </div>


                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <input type="hidden" name="cod_usuario" id="cod_usuario"
                                        value='<?php echo $cod_usuario_mod; ?>' />
                                    <div id="btn-guardar" class="btn btn-primary">Guardar</div>
                                    <div id="btn-cancelar" class="btn btn-secondary">Cancelar</div>
                                    <div class='small text-danger bold pt-2'>* Campos obligatorios</div>
                                    <div id='msn'></div>
                                </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ;
                ?>


            <!-- Footer opened -->
            <?php
            include ("footer.php");
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


        <!-- Internal Data tables -->
        <script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
        <script src="../assets/plugins/datatable/datatables.min.js"></script>
        <script src="../assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
        <script src="../assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
        <script src="../assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
        <script src="../assets/plugins/datatable/js/jszip.min.js"></script>
        <script src="../assets/plugins/datatable/js/buttons.html5.min.js"></script>
        <script src="../assets/plugins/datatable/js/buttons.print.min.js"></script>
        <script src="../assets/plugins/datatable/js/buttons.colVis.min.js"></script>
        <script src="../assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
        <script src="../assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>

        <!--Internal  Datatable js -->
        <!-- custom js -->

        <script src="../assets/js/custom.js"></script>

        <script>

            const alert = $("#alert"),
                alertContraseña = $('#alertContraseña');

            var foto_plano;

            $("#btn-cancelar").click(function (e) {
                e.preventDefault();
                window.history.back();
            });


            $("#btn-guardar").on("click", function () {

                usuario = $("#usuario").val().trim();
                nombre = $("#nombre").val().trim();
                apellido = $("#apellido").val().trim();
                login = $("#login").val().trim();
                pass = $("#pass").val().trim();
                pass2 = $("#pass2").val().trim();
                activo = $("#activo").is(":checked");

                cod_usuario = $("#cod_usuario").val();// en el caso de que sea un nuevo articulo, el valor es 0

                enviar = "";
                cambiarpass = false;

                if (activo) {
                    activo = 1;
                } else {
                    activo = 0;
                }


                if (usuario == "" || nombre == "" || apellido == "" || login == "") {

                    alert.fadeIn();

                    setTimeout(() => {
                        alert.fadeOut();
                    }, 3000);

                    enviar = false;
                } else {
                    if (cod_usuario == 0) {
                        if ((pass != "" && pass != pass2) || pass == "" || pass2 == "") {
                            alertContraseña.fadeIn();
                            setTimeout(() => {
                                alertContraseña.fadeOut();
                            }, 3000);
                            enviar = false;
                        } else {
                            enviar = true;
                        }
                    } else {
                        if (pass != "" || pass2 != "") {
                            if (pass != pass2) {
                                alertContraseña.fadeIn();
                                setTimeout(() => {
                                    alertContraseña.fadeOut();
                                }, 3000);
                                enviar = false;
                            } else {
                                enviar = true;
                                cambiarpass = true;
                            }
                        } else {
                            enviar = true;
                        }
                    }

                }
                var formData = new FormData();

                formData.append('usuario', usuario);
                formData.append('nombre', nombre);
                formData.append('apellido', apellido);
                formData.append('login', login);
                formData.append('pass', pass);
                formData.append('pass2', pass2);
                formData.append('cod_usuario', cod_usuario);
                formData.append('cambiarpass', cambiarpass);
                formData.append('activo', activo);

                if (enviar) {
                    $.ajax({
                        url: 'operarios_jquery.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $("#msn").html('<div class="text-center col-md-12 m-5"><div class="spinner-border avatar-lg text-primary m-2" role="status"></div></div>');
                        },
                        success: function (response) {
                            //$("#msn").html(response);
                            console.log(response);

                            window.location.href = "operarios.php";
                        }
                    });
                }
            });



        </script>
</body>

</html>