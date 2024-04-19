<?php
@session_start();
if (!isset($_SESSION['cod_usuario'])) {
    header("location: index.php");
}

include ("../conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
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
                            <div class="d-flex"><h4 class="content-title mb-0 my-auto">Apps</h4><span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Cards</span></div>
                        </div>
                    </div>
                    <!-- breadcrumb -->

                    <div class="row">
                        <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5 class="card-title mb-0 pb-0">Card title</h5>
                                </div>
                                <div class="card-body">
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                </div>
                                <div class="card-footer">
                                    Card footer
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card card-primary">
                                <div class="card-header pb-0">
                                    <h5 class="card-title mb-0 pb-0">Card title</h5>
                                </div>
                                <div class="card-body text-primary">
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                </div>
                                <div class="card-footer">
                                    Card footer
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card card-secondary">
                                <div class="card-header pb-0">
                                    <h5 class="card-title mb-0 pb-0">Card title</h5>
                                </div>
                                <div class="card-body text-secondary">
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                </div>
                                <div class="card-footer">
                                    Card footer
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card card-success">
                                <div class="card-header pb-0">
                                    <h5 class="card-title mb-0 pb-0">Card title</h5>
                                </div>
                                <div class="card-body text-success">
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                </div>
                                <div class="card-footer">
                                    Card footer
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card card-warning">
                                <div class="card-header pb-0">
                                    <h5 class="card-title mb-0 pb-0">Card title</h5>
                                </div>
                                <div class="card-body text-warning">
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                </div>
                                <div class="card-footer">
                                    Card footer
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card card-info">
                                <div class="card-header pb-0">
                                    <h5 class="card-title mb-0 pb-0">Card title</h5>
                                </div>
                                <div class="card-body text-info">
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                </div>
                                <div class="card-footer">
                                    Card footer
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card card-purple">
                                <div class="card-header pb-0">
                                    <h5 class="card-title mb-0 pb-0">Card title</h5>
                                </div>
                                <div class="card-body text-purple">
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                </div>
                                <div class="card-footer">
                                    Card footer
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card card-danger">
                                <div class="card-header pb-0">
                                    <h5 class="card-title mb-0 pb-0">Card title</h5>
                                </div>
                                <div class="card-body text-danger">
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                </div>
                                <div class="card-footer">
                                    Card footer
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

        <!-- custom js -->
        <script src="../assets/js/custom.js"></script>

    </body>
</html>
