<?php
@session_start();
if (!isset($_SESSION['cod_usuario'])) {
    header("location: index.php");
}

include("../conexion.php");

if (isset($_GET['cod'])) { // añadir nuevo articulo

    $cod_cliente_mod = $_GET['cod'];

    $sql = "select * from clientes where cod_cliente=" . $cod_cliente_mod;
    $result = $conexion->query($sql);

    while ($fila1 = $result->fetch_assoc()) {
        $plano = $fila1['plano'];
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
        include("centerlogo-header.php");
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
                        <div class="d-flex"><a href='clientes.php'>
                                <h4 class="content-title mb-0 my-auto">Clientes</h4>
                            </a><span class="text-muted mt-1 tx-13 ms-2 mb-0">/
                                Asignar máquinas al plano
                            </span></div>
                    </div>
                </div>
                <!-- breadcrumb -->
                <div class="row  ">
                    <div class="col-12">
                        <div class="card  box-shadow-0">
                            <div class="card-header">
                                <div class="form-group mb-0 ">
                                    <div class="d-flex justify-content-between">
                                        <a href="clientes.php">
                                            <div class="btn btn-secondary">Volver</div>
                                        </a>

                                        <button class="btn btn-danger" id="delete_plan">
                                            Eliminar plano
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <canvas id="canvas_img" class="w-100 m-3" style="display:none">

                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Container closed -->
            <button data-bs-target="#select2modal" data-bs-toggle="modal" href="" id="btn-modal"></button>
        </div>
        <!-- main-content closed -->

        <!-- Basic modal -->
        <div class="modal" id="select2modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Asignar Máquina</h6><button aria-label="Close" class="close"
                            data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <!-- Select2 -->
                        <label>Máquina</label>
                        <select class="form-control " id="select-maquina" id='modal_cod_articulo'>
                            <option label="Elija una maquina" selected></option>
                            <?php
                            $sql = "Select * from maquinas where activa=1 and id_cliente=" . $cod_cliente_mod . " order by nombre_maquina";
                            // echo $sql;
                            $result = $conexion->query($sql);
                            while ($filas = $result->fetch_assoc()) {
                                echo "<option value=" . $filas['cod_maquina'] . ">" . $filas['nombre_maquina'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="button" id='btn_asignar'>Asignar</button>
                        <button class="btn ripple btn-secondary" id="cerrar_modal" data-bs-dismiss="modal"
                            type="button">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->

        <!-- Footer opened -->
        <?php
        include("footer.php");
        ?>
        <!-- Footer closed -->
    </div>
    <!-- End Page -->
    <!-- custom js -->


    <!-- JQuery min js -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Bundle js -->
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Ionicons js -->
    <script src="../assets/plugins/ionicons/ionicons.js"></script>

    <!-- Moment js -->
    <script src="../assets/plugins/moment/moment.js"></script>


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
    <!-- <script src="../assets/plugins/sidebar/sidebar.js"></script>
    <script src="../assets/plugins/sidebar/sidebar-custom.js"></script> -->
    <script src="../assets/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        var posicion_maquina;
        const ctx = document.getElementById("canvas_img").getContext("2d");
        const canvas = document.getElementById("canvas_img");

        $(document).ready(function () {
            var img = new Image();
            img.src = "../planos/" + <?php echo $_GET['cod'] ?> + "/<?php echo $plano ?>";
            // console.log(data);
            img.onload = function () {
                // console.log(data);
                canvas.width = this.width;
                canvas.height = this.height;
                $('#canvas_img').show();
                ctx.drawImage(this, 0, 0);

                //Get assigned machines
                $.ajax({
                    type: "POST",
                    url: "get_assigned_machines.php",
                    data: "cod_cliente=" + <?php echo $cod_cliente_mod ?>,
                    success: function (response) {
                        // console.log(response);
                        if (response)
                            drawMachines(JSON.parse(response));
                    }
                });

            }
        });

        function drawMachines(options) {
            let optionsArr = [options];

            var rect = canvas.getBoundingClientRect(),
                scaleX = canvas.width / rect.width,
                scaleY = canvas.height / rect.height;

            var img = new Image();
            img.src = "../Maquina_icono/maquina_icono.svg";
            img.title = 'maquina1';

            console.log(optionsArr);
            img.onload = function () {
                $('#canvas_img').show();

                for (let option of options) {
                    console.log('enmtra');
                    ctx.drawImage(img, option.posicion_plano_x - 10, option.posicion_plano_y - 10, 20, 20);

                    ctx.font = "8px Arial";
                    ctx.fillText("Nº serie: " + option.nserie, parseInt(option.posicion_plano_x) - 15, parseInt(option.posicion_plano_y) + 15);
                }


            }
        }

        $("#canvas_img").on("mousedown touchstart", function (e) {

            var rect = canvas.getBoundingClientRect(),
                scaleX = canvas.width / rect.width,
                scaleY = canvas.height / rect.height;

            posicion_maquina = {
                x: (e.clientX - rect.left) * scaleX,
                y: (e.clientY - rect.top) * scaleY
            }

            if (posicion_maquina)
                $('#btn-modal').trigger('click');

        });

        $("#btn_asignar").on("click", function (e) {

            let cod_maquina = $('#select-maquina').val();

            posicion_maquina.cod_maquina = cod_maquina;

            $.ajax({
                type: "POST",
                url: "assign_maquina.php",
                data: posicion_maquina,
                success: function (response) {
                    if (response) {
                        // Clear canvas
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        //Draw plan
                        var img = new Image();
                        img.src = "../planos/" + <?php echo $_GET['cod'] ?> + "/<?php echo $plano ?>";
                        img.onload = function () {

                            $('#canvas_img').show();
                            ctx.drawImage(img, -10, -10);
                        }

                        //Get assigned machines
                        ctx.restore();
                        $.ajax({
                            type: "POST",
                            url: "get_assigned_machines.php",
                            data: "cod_cliente=" + <?php echo $cod_cliente_mod ?>,
                            success: function (response) {
                                // console.log(response);
                                if (response)
                                    drawMachines(JSON.parse(response));
                            }
                        });
                    }
                }
            });

            $('#cerrar_modal').trigger('click');
        });

        // Delete plan
        $('#delete_plan').click(function (e) {
            e.preventDefault();

            //Ask if sure
            Swal.fire({
                title: '¿Desea eliminar el plano?',
                text: 'También se borrarán las posiciones de las máquinas asociadas',
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: 'Cancelar',
                denyButtonText: 'Borrar',
                showLoaderOnDeny: true,
                customClass: {
                    actions: 'my-actions',
                    cancelButton: 'order-1 right-gap',
                    confirmButton: 'order-2',
                    denyButton: 'order-3',
                },
                preDeny: () => {
                    $.ajax({
                        type: "POST",
                        url: "delete_plan.php",
                        data: "cod_cli=" + <?php echo $cod_cliente_mod ?>,
                        success: function (response) {
                            console.log(response);
                        }
                    });
                },
            }).then((result) => {

                //Finally delete plan
                if (result.isDenied) {
                    Swal.fire({
                        title: 'Plano borrado',
                        text: '',
                        icon: 'success',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed)//Redirect to clients list
                            window.location.href = 'clientes.php';
                    });
                }
            })

        });

    </script>
</body>

</html>