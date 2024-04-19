<?php
@session_start();
if (!isset($_SESSION['cod_usuario'])) {
    header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");
?>
<!DOCTYPE html>
<html lang="es">
    <!-- Internal Data table css -->
    <link href="../assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatable/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="../assets/plugins/datatable/responsive.bootstrap5.css" rel="stylesheet" />
    <link href="../assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../assets/plugins/datatable/responsive.dataTables.min.css" rel="stylesheet">
    <link href="../assets/plugins/select2/css/select2.min.css" rel="stylesheet">

    <!--- Internal Sweet-Alert css-->
    <link href="../assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">

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
                            <div class="d-flex"><h4 class="content-title mb-0 my-auto">Presupuestos</h4></div>
                        </div>
                    </div>
                    <!-- breadcrumb -->

                    <div class="row row-sm">

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header pb-0 text-right">
                                    <a href="presupuestos-gestion.php"><div class="btn btn-success">Nuevo Presupuesto</div></a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive hoverable-table">
                                        <table id="tabla_listado" class="table text-md-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class='text-center'>Presupuesto</th>
                                                    <th>Cliente</th>
                                                    <th data-orderable="false">Observaciones</th>
                                                    <th class='text-center' >Fecha</th>
                                                    <th class='text-right'>Importe</th>
                                                    <th class='text-center'> Acp.</th>
                                                    <th class='text-center'> Alb.</th>
                                                    <th data-orderable="false"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "select * from presupuestos p
												inner join clientes c on c.cod_cliente= p.id_cliente
												order by fecha asc";
                                                $result = $conexion->query($sql);
                                                if ($result->num_rows == 0) {// Usuario web no existente
                                                    echo "No hay clientes";
                                                } else {// existe el usuario web
                                                    while ($fila1 = $result->fetch_assoc()) {
                                                        if ($fila1['albaran'] <> "") {
                                                            $albaraneado = "<span class='btn_abrir_albaran puntero' cod='" . $fila1['albaran'] . "'>" . $fila1['albaran'] . "</span>";
                                                            $borrar_albaraneado = "<i class='fa fa-trash tx-gray-400'></i>";
                                                            $icono_mod = "eye";
                                                        } else {
                                                            $albaraneado = "<div class='badge bg-danger btn_pasar_albaran puntero' cod='" . $fila1['cod_presupuesto'] . "'>Pasar a albaran</div>";
                                                            $borrar_albaraneado = "<i class='fa fa-trash btn_eliminar text-danger puntero' cod=" . $fila1['cod_presupuesto'] . " ></i>";
                                                            $icono_mod = "edit";
                                                        }
                                                        if ($fila1['aceptado'] == 1) {
                                                            $aceptado = "<div class='badge bg-success' alt='Aceptada'>A</div>";
                                                        } else {
                                                            $aceptado = "<span class='badge bg-danger' alt='Pendiente'>P</span>";
                                                        }
                                                        echo "
                                                            <tr id='reg_" . $fila1['cod_presupuesto'] . "'>
                                                                    <td class=' text-center tx-bold wd-5p'>" . $fila1['cod_presupuesto'] . "</td>
                                                                    <td class='tx-bold wd-20p'>" . $fila1['razon_social'] . " <small>(" . $fila1['cif'] . ")</small></td>
                                                                    <td class='small'>" . $fila1['observaciones'] . "</td>
                                                                    <td class='text-center wd-10p'>" . formatearfecha($fila1['fecha']) . "</td>
                                                                    <td class='text-right tx-bold wd-5p'>" . $fila1['importe_descuento'] . " €</td>
                                                                    <td class='text-center wd-5p'>" . $aceptado . "</td>
                                                                    <td class='text-center wd-10p'>" . $albaraneado . "</td>
                                                                    <td class='text-center  wd-5p'><i class='fa fa-" . $icono_mod . " btn_modificar puntero' cod=" . $fila1['cod_presupuesto'] . "></i>&nbsp;
                                                                    " . $borrar_albaraneado . "</td>
                                                            </tr>";
                                                    }
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                        <form method="post" name='form_modificar' id="form_modificar" action="presupuestos-gestion.php" >
                                            <input type=hidden name='cod_presupuesto' id='cod_presupuesto' />
                                        </form>
                                        <form method="post" name='form_modificar_albaran' id="form_modificar_albaran" action="albaranes-gestion.php" >
                                            <input type=hidden name='cod_albaran' id='cod_albaran' />
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


                <!--<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- custom js -->
        <script src="../assets/js/custom.js"></script>
        <script>

            $('#tabla_listado').DataTable({
                responsive: true,
                dom: 'Bfrtip',
			buttons:[
				'pdf'
			],
                order: [[0, "desc"]],
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                }
            });

            $(".btn_modificar").on("click", function () {
                codigo = $(this).attr("cod");
                $("#cod_presupuesto").val(codigo);
                $("#form_modificar").submit();
            })

            $(".btn_abrir_albaran").on("click", function () {
                codigo = $(this).attr("cod");
                $("#cod_albaran").val(codigo);
                $("#form_modificar_albaran").submit();
            })



            $(".btn_eliminar").on("click", function () {
                codigo = $(this).attr("cod");
                if (confirm("Se va a eliminar cliente. Confirmar?")) {
                    $.ajax({
                        url: 'presupuesto_eliminar_jquery.php',
                        type: 'post',
                        data: "cod_presupuesto=" + codigo,
                        beforeSend: function () {
                        },
                        success: function (response) {
                            $("#reg_" + codigo).css("display", "none");
                        }
                    });

                }
            });


            $(document).on('click', '.btn_pasar_albaran', function () {
                codigo = $(this).attr('cod');

                swal.fire({
                    title: "Pasar a Albarán",
                    text: "Se va a pasar a albarán este presupuesto, para hacerlo, hay que seleccionar un Tiempo de pagos",
                    type: "warning",
                    input: 'select',
                    inputOptions: {
<?php
$sql_t = "select * from tiempos_pago order by valor desc;";
$resultt = $conexion->query($sql_t);
$i = 0;
while ($filat = $resultt->fetch_assoc()) {
    if ($i == 0) {
        echo "'" . $filat['cod_tiempos_pago'] . "': '" . $filat['descripcion'] . " (" . $filat['valor'] . "%)'";
    } else {
        echo ", '" . $filat['cod_tiempos_pago'] . "': '" . $filat['descripcion'] . " (" . $filat['valor'] . "%)'";
    }
    $i++;
}
?>
                    },
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Pasar",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false,

                    inputPlaceholder: 'Seleccionar un tiempo de pago',
                    showCancelButton: true,
                    inputValidator: (value) => {
                        return new Promise((resolve) => {
                            if (value === '') {
                                resolve('Debes seleccionar un tiempo de pago')
                            } else {

                                $.ajax({
                                    url: 'presupuesto_a_albaran.php',
                                    type: 'post',
                                    data: "cod_presupuesto=" + codigo + "&cod_tiempo_pago=" + value,
                                    beforeSend: function () {
                                    },
                                    success: function (response) {
                                        swal.fire("Albaraneado!", "Se ha pasado a albarán.", "success");
                                        window.location.href = "albaranes.php";
                                    }
                                })//ajax
                                //resolve()
                            }
                        })
                    }

                });
            })

        </script>
    </body>
</html>
