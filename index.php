<?php
@session_start();
session_destroy();
@session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>

        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>

        <!-- Title -->
        <title> D3IDI -   </title>

        <!-- Favicon -->
        <link rel="icon" href="assets/img/brand/favicon.png" type="image/x-icon"/>

        <!-- Icons css -->
        <link href="assets/css/icons.css" rel="stylesheet">

        <!-- Bootstrap css -->
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!--  Right-sidemenu css -->
        <link href="assets/plugins/sidebar/sidebar.css" rel="stylesheet">

        <!--  Custom Scroll bar-->
        <link href="assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

        <!--- Style css --->
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/boxed.css" rel="stylesheet">
        <link href="assets/css/dark-boxed.css" rel="stylesheet">

        <!--- Dark-mode css --->
        <link href="assets/css/style-dark.css" rel="stylesheet">

        <!---Skinmodes css-->
        <link href="assets/css/skin-modes.css" rel="stylesheet" />

        <!--- Animations css-->
        <link href="assets/css/animate.css" rel="stylesheet">

    </head>
    <body class="error-page1 main-body bg-light text-dark">

        <!-- Loader -->
        <div id="global-loader">
            <img src="assets/img/loader.svg" class="loader-img" alt="Loader">
        </div>
        <!-- /Loader -->

        <!-- Page -->
        <div class="page">

            <div class="container-fluid">
                <div class="row no-gutter">
                    <div class="col-md-12 col-lg-12 col-xl-12 bg-white">
                        <div class="d-flex flex-row justify-content-around ">

                            <div class="col-md-6 col-lg-6 col-xl-5 bg-gray-200">
                                <div class="login d-flex align-items-center py-2">
                                    <!-- Demo content-->
                                    <div class="container p-0">
                                        <div class="row">
                                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                                <div class="card-sigin">
                                                    <div class="card-sigin">
                                                        <div class="main-signup-header">
                                                            <h2>Bienvenidos a D3IDI</h2>
                                                            <h5 class="fw-semibold mb-4">Introduzca su usuario y contraseña</h5>
                                                            <form action="#">
                                                                <div class="form-group">
                                                                    <label>Usuario</label> <input class="form-control" id='usuario' placeholder="introduzca su usuario" type="text">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Contraseña</label> <input class="form-control" id='password' placeholder="Introduzca la contraseña" type="password">
                                                                </div><div class="btn btn-main-primary btn-block" id="btn_acceder">Acceder</div>
                                                                <div id="msn" class="fw-semibold m-2 text-danger text-center">&nbsp;</div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End -->
                                </div>
                            </div><!-- End -->

                        </div>
                    </div>
                    <!-- The content half -->

                </div>
            </div>

        </div>
        <!-- End Page -->

        <!-- JQuery min js -->
        <script src="assets/plugins/jquery/jquery.min.js"></script>

        <!-- Bootstrap Bundle js -->
        <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Ionicons js -->
        <script src="assets/plugins/ionicons/ionicons.js"></script>

        <!-- Moment js -->
        <script src="assets/plugins/moment/moment.js"></script>

        <!-- P-scroll js -->
        <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

        <!-- eva-icons js -->
        <script src="assets/js/eva-icons.min.js"></script>

        <!-- Rating js-->
        <script src="assets/plugins/rating/jquery.rating-stars.js"></script>
        <script src="assets/plugins/rating/jquery.barrating.js"></script>

        <!-- Custom Scroll bar Js-->
        <script src="assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

        <!-- custom js -->
        <script src="assets/js/custom.js"></script>
        <script>            
            $('#btn_acceder').on("click", function () {
                usuario = $('#usuario').val();
                pass = $("#password").val();

                if (usuario == "" || pass == "") {
                    $("#msn").html("Debes rellenar los datos");
                } else {
                    //$("#msn").html('<div id="msn" class="fw-semibold m-2 text-danger text-center">&nbsp;</div>');
                    $.ajax({
                        url: 'acceso.php',
                        type: 'POST',
                        data: "pass=" + pass + "&usuario=" + usuario,
                        beforeSend: function () {
                            $('#msn').html('<div class="spinner-border m-2" role="status"><span class="sr-only">Loading...</span></div>');
                        },
                        success: function (resultado) {
                            //alert(resultado)
                            if (resultado == 0) {
                                $('#msn').html('Error en el acceso');
                            } else if (resultado == 1) {
                                $(location).attr('href', 'inicio.php');
                            }
                        }
                    });
                }
            });
        </script>
    </body>
</html>
