<?php
@session_start();
if (!isset ($_SESSION['cod_usuario'])) {
    header("location: index.php");
}

include ("../conexion.php");

if (!isset ($_POST['cod_cliente'])) { // añadir nuevo articulo
    $cod_cliente_mod = 0;
    $razon_social = "";
    $nombre = "";
    $cif = "";
    $direccion = "";
    $telefono = "";
    $email = "";
    $poblacion = "";
    $provincia = "";
    $login = "";
    $breadcrumb = "Nuevo";
} else { // Modificamos el articulo
    $cod_cliente_mod = $_POST['cod_cliente'];

    $sql = "select * from clientes where cod_cliente=" . $cod_cliente_mod;
    $result = $conexion->query($sql);

    while ($fila1 = $result->fetch_assoc()) {
        $razon_social = $fila1['razon_social'];

        $nombre = $fila1['nombre'];
        $cif = $fila1['cif'];
        $direccion = $fila1['direccion'];
        $telefono = $fila1['telefono'];
        $email = $fila1['email'];
        $cp = $fila1['cp'];
        $poblacion = $fila1['poblacion'];
        $provincia = $fila1['telefono'];
        $login = $fila1['login'];
        $iva = $fila1['iva'];
        $tarifa = $fila1['id_tarifa'];
        $re = $fila1['re'];
        $plano = $fila1['plano'];
    }

    /*
     * Pregunto por el tipo de usuarios que va a ver esta página. En el caso de ser tipo=0 (administrador) se muestra la palabra Modificar en el breadcrumb
     * En el caso de ser distinto a 0 (Operario) en esta pantalla solo se muestran las máquinas asociadas sl cliente y por eso el breadcrumb es "maquinas asociadas"
     * 
     */

    if ($_SESSION['tipo'] == 0) {
        $breadcrumb = "Modificar";
    } elseif ($_SESSION['tipo'] == 1) {
        $breadcrumb = "Máquinas asociadas";
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
                                <h4 class="content-title mb-0 my-auto">Clientes</h4>
                            </a><span class="text-muted mt-1 tx-13 ms-2 mb-0">/
                                <?php echo $breadcrumb; ?>
                            </span></div>
                    </div>
                </div>
                <!-- breadcrumb -->
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
                                                <h4>Datos Fiscales</h4>
                                            </div>
                                            <div class='col-md-4 pt-2'>
                                                <label class="form-label">Razón Social <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" required id="razon_social"
                                                    placeholder="" value='<?php echo $razon_social; ?>'>
                                            </div>

                                            <div class='col-md-4 pt-2'>
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" placeholder=""
                                                    value='<?php echo $nombre; ?>'>
                                            </div>

                                            <div class='col-md-4 pt-2'>
                                                <label class="form-label">CIF <span class="text-danger">*</span></label>
                                                <input type="text" required class="form-control" id="cif" placeholder=""
                                                    value='<?php echo $cif; ?>'>
                                            </div>

                                            <div class='col-md-4 pt-2'>
                                                <label class="form-label">Dirección</label>
                                                <input type="text" class="form-control" id="direccion" placeholder=""
                                                    value='<?php echo $direccion; ?>'>
                                            </div>

                                            <div class='col-md-2 pt-2'>
                                                <label class="form-label">CP <span class="text-danger">*</span></label>
                                                <input type="text" required class="form-control" id="cp" placeholder=""
                                                    value='<?php echo $cp; ?>'>
                                            </div>

                                            <div class='col-md-3 pt-2'>
                                                <label class="form-label">Población</label>
                                                <input type="text" class="form-control" id="poblacion" placeholder=""
                                                    value='<?php echo $poblacion; ?>'>
                                            </div>

                                            <div class='col-md-3 pt-2'>
                                                <label class="form-label">Provincia</label>
                                                <input type="text" class="form-control" id="provincia" placeholder=""
                                                    value='<?php echo $provincia; ?>'>
                                            </div>

                                            <div class='col-md-2 pt-2'>
                                                <label class="form-label">Telefono <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" required class="form-control" id="telefono"
                                                    placeholder="" value='<?php echo $telefono; ?>'>
                                            </div>

                                            <div class='col-md-3 pt-2'>
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="text" required class="form-control" id="email" placeholder=""
                                                    value='<?php echo $email; ?>'>
                                            </div>

                                            <div class='col-md-2 pt-2'>
                                                <label class="form-label">Tarifa <span class="text-danger">*</span></label>
                                                <select id='tarifa' required name='tarifa' class="form-control">
                                                    <option></option>
                                                    <?php
                                                    $sqlT = "select * from tarifas order by descripcion asc";
                                                    $resulT = $conexion->query($sqlT);
                                                    while ($filaT = $resulT->fetch_assoc()) {
                                                        if ($filaT['cod_tarifa'] == $tarifa) {
                                                            echo "<option value=" . $filaT['cod_tarifa'] . " selected>" . $filaT['descripcion'] . " (" . $filaT['valor'] . "%)</option>";
                                                        } else {
                                                            echo "<option value=" . $filaT['cod_tarifa'] . ">" . $filaT['descripcion'] . " (" . $filaT['valor'] . "%)</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class='col-md-2 pt-2'>
                                                <label class="form-label">RE <span class="text-danger">*</span></label>
                                                <select id='re' name='re' required class="form-control">
                                                    <?php

                                                    if ($re == '5.2') {
                                                        echo "<option value='" . $re . "' selected>" . $re . "%</option>";
                                                        echo "<option value='0'>0%</option>";
                                                    } else {
                                                        echo "<option value='0'>0%</option>";
                                                        echo "<option value='5.2'>5.2%</option>";

                                                    }
                                                    ?>
                                                    <!-- <option value="null"></option> -->
                                                </select>
                                            </div>

                                            <div class='col-md-2 pt-2'>
                                                <label class="form-label">IVA <span class="text-danger">*</span></label>
                                                <select id='iva' name='iva' required class="form-control">
                                                    <?php
                                                    if ($iva == '10') {
                                                        echo "<option value='" . $iva . "' selected>" . $iva . "%</option>";
                                                        echo '<option value=21>21%</option>';
                                                    } elseif ($iva = '21') {
                                                        echo "<option value='" . $iva . "' selected>" . $iva . "%</option>";
                                                        echo '<option value=10>10%</option>';
                                                    } else {
                                                        echo '<option value=10>10%</option>';
                                                        echo '<option value=21>21%</option>';
                                                    }
                                                    ?>



                                                </select>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-12 pt-2'>
                                                <hr />
                                                <h4>Datos Acceso Web</h4>
                                            </div>
                                            <div class=' col-md-4 pt-2'>
                                                <label class="form-label">Login <span class="text-danger">*</span></label>
                                                <input type="text" required class="form-control" id="login" placeholder=""
                                                    value='<?php echo $login; ?>'>
                                            </div>

                                            <div class='col-md-4 pt-2'>
                                                <label class="form-label">Contraseña <span
                                                        class="text-danger">*</span></label>
                                                <input type="password" required class="form-control" id="pass"
                                                    placeholder="" value=''>
                                            </div>

                                            <div class='col-md-4 pt-2'>
                                                <label class="form-label">Rep. contraseña</label>
                                                <input type="password" class="form-control" id="pass2" placeholder=""
                                                    value=''>
                                            </div>

                                        </div>

                                        <div class="row mt-4">
                                            <div class='col-12 pt-2'>
                                                <hr />
                                                <h4>Imagen plano</h4>
                                            </div>
                                            <div class="col-5 pt-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span style="height: 100%;" id="label-plano"
                                                            class="input-group-text" id="inputGroupFileAddon01">
                                                            Subir
                                                        </span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input id="plano" accept="image/png,image/jpeg" type="file"
                                                            name="plano" class="custom-file-input" id="inputGroupFile01"
                                                            aria-describedby="inputGroupFileAddon01">
                                                        <label class="custom-file-label" for="inputGroupFile01">Seleccione
                                                            una
                                                            foto</label>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row justify-content-center align-items-center g-2">
                                            <div class="col" id="imagen-container">
                                                <canvas id="canvas_img" class="w-100 p-3" style="display:none">

                                                </canvas>
                                                <?php
                                                if (isset ($plano) && trim($plano) != "") {

                                                    echo '<img src="../planos/' . $_POST['cod_cliente'] . '/' . $plano . '" class="mt-2 w-100 p-3 rounded" alt="">';
                                                    echo '<a name="" id="" class="btn ripple btn-teal" href="asignar_maquina_plano.php?cod=' . $_POST['cod_cliente'] . '" role="button">Asignar máquina al plano</a>';
                                                }
                                                ?>

                                            </div>
                                        </div>

                                        <div class="form-group mb-0 mt-3 justify-content-end">
                                            <input type="hidden" name="cod_cliente" id="cod_cliente"
                                                value='<?php echo $cod_cliente_mod; ?>' />
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


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">

                            <div class="card-header pb-0">
                                <div class='row'>
                                    <div class='col-6'>
                                        <h4>Máquinas asociadas</h4>
                                    </div>
                                    <?php
                                    if ($_SESSION['tipo'] == 0) {
                                        ?>
                                        <div class='col-6  text-right'>
                                            <a class="btn ripple btn-teal" id='btn_modal_annadir_maquina'
                                                data-bs-target="#select2modal" data-bs-toggle="modal" href="">Añadir
                                                Máquina</a>
                                        </div>

                                        <?php
                                    }
                                    ?>
                                </div>

                            </div>
                            <div class="card-body">

                                <div class="table-responsive hoverable-table">
                                    <table id="tabla_listado" class="table text-md-nowrap">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Número de Serie</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "select * from maquinas m
                                                        inner join articulos a on a.cod_articulo=m.id_articulo
                                                        where activa=1 and id_cliente =" . $cod_cliente_mod;
                                            $result = $conexion->query($sql);
                                            if ($result->num_rows == 0) { // Usuario web no existente
                                                echo "No hay maquinas";
                                            } else { // existe el usuario web
                                                while ($fila1 = $result->fetch_assoc()) {

                                                    echo "
                                                            <tr id='reg_" . $fila1['cod_maquina'] . "'>
                                                                    <td ><img style='max-height:50px' src='../fotos/" . $fila1['id_articulo'] . "/" . $fila1['id_articulo'] . ".jpg' class='img-fluid' /></td>
                                                                    <td class='text-left tx-bold'>" . $fila1['nserie'] . "</td>
                                                                    <td class='tx-bold'>" . $fila1['nombre_maquina'] . "</td>
                                                                    <td class='text-left small'>" . $fila1['descripcion_maquina'] . "</td>";
                                                    if ($_SESSION['tipo'] == 0) {
                                                        echo "<td class='text-center  wd-5p'><i class='fa fa-edit btn_modificar puntero' cod_articulo='" . $fila1['id_articulo'] . "' desc='" . $fila1['descripcion_maquina'] . "' nombre='" . $fila1['nombre_maquina'] . "' ns='" . $fila1['nserie'] . "' cod_maquina=" . $fila1['cod_maquina'] . " data-bs-toggle='modal' data-bs-target='#select2modal'></i>&nbsp;<i class='fa fa-trash btn_eliminar puntero tx-danger'  cod=" . $fila1['cod_maquina'] . " ></i></td>";
                                                    } else {
                                                        echo "<td class='text-center wp-5'><i class='icon ion-ios-list-box btn_revision puntero' cod_maquina=" . $fila1['cod_maquina'] . "></i></td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <div class="form-group mb-0 ">
                                    <div>
                                        <a href="clientes.php">
                                            <div class="btn btn-secondary">Volver</div>
                                        </a>
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


        <!-- Basic modal -->
        <div class="modal" id="select2modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Añadir Máquina</h6><button aria-label="Close" class="close"
                            data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <!-- Select2 -->
                        <label>Maquina</label>
                        <select class="form-control " id='modal_cod_articulo'>
                            <option label="Elija una maquina" selected></option>
                            <?php
                            $sql = "Select * from articulos where tipo =1 and activo=1 order by nombre";
                            $result = $conexion->query($sql);
                            while ($filas = $result->fetch_assoc()) {
                                echo "<option value=" . $filas['cod_articulo'] . ">" . $filas['nombre'] . "</option>";
                            }
                            ?>
                        </select>
                        <!-- Select2 -->
                        <label>Nombre</label>
                        <input type=text id='modal_nombre' class='form-control' />
                        <label>Numero de serie</label>
                        <input type=text id='modal_sn' class='form-control' />
                        <label>Descripcion</label>
                        <textarea id='modal_descripcion' class='form-control'></textarea>

                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="button" id='btn_annadir_maquina'>Crear</button>
                        <input type=hidden id='modal_cod_cliente' value=<?php echo $cod_cliente_mod; ?>>
                        <input type=hidden id='modal_cod_maquina'>
                        <button class="btn ripple btn-secondary" id="cerrar_modal" data-bs-dismiss="modal"
                            type="button">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->

        <form id='form_revisiones' action='revisiones.php' method="POST">
            <input type=hidden id='cod_cliente' name='cod_cliente' value=<?php echo $cod_cliente_mod; ?>>
            <input type=hidden id='cod_maquina' name='cod_maquina'>
        </form>

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

        $('#plano').change(function (e) {
            e.preventDefault();
            foto_plano = e.currentTarget.value.split("\\")[2];
            $('#label-plano').text(e.currentTarget.value.split("\\")[2]);
        });

        $("#btn-guardar").on("click", function () {

            razon_social = $("#razon_social").val().trim();
            nombre = $("#nombre").val().trim();
            cif = $("#cif").val().trim();
            direccion = $("#direccion").val().trim();
            cp = $("#cp").val().trim();
            telefono = $("#telefono").val().trim();
            email = $("#email").val().trim();
            poblacion = $("#poblacion").val().trim();
            provincia = $("#provincia").val().trim();
            login = $("#login").val().trim();

            pass = $("#pass").val().trim();
            pass2 = $("#pass2").val().trim();

            iva = $("#iva").val();
            re = $("#re").val();

            tarifa = $("#tarifa").val();


            cod_cliente = $("#cod_cliente").val();// en el caso de que sea un nuevo articulo, el valor es 0

            enviar = "";
            cambiarpass = false;
            if (razon_social == "" || cif == "" || telefono == "" || email == "" || login == "" || cp == "" || iva == "" || tarifa == "" || isNaN(telefono) || isNaN(cp)) {

                alert.fadeIn();

                setTimeout(() => {
                    alert.fadeOut();
                }, 3000);

                enviar = false;
            } else {
                if (cod_cliente == 0) {
                    if ((pass != "" && pass != pass2) || pass == "") {
                        alertContraseña.fadeIn();
                        setTimeout(() => {
                            alertContraseña.fadeOut();
                        }, 3000);
                        enviar = false;
                    } else {
                        enviar = true;
                    }
                } else {
                    if (pass != "") {
                        if (pass != pass2) {
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

            foto_plano = $('#plano')[0].files[0];
            formData.append('file', foto_plano);
            formData.append('cod_cliente', cod_cliente);
            formData.append('razon_social', razon_social);
            formData.append('nombre', nombre);
            formData.append('cif', cif);
            formData.append('direccion', direccion);
            formData.append('cp', cp);
            formData.append('telefono', telefono);
            formData.append('email', email);
            formData.append('poblacion', poblacion);
            formData.append('provincia', provincia);
            formData.append('login', login);
            formData.append('pass', pass);
            formData.append('pass2', pass2);
            formData.append('cambiarpass', cambiarpass);
            formData.append('tarifa', tarifa);
            formData.append('iva', iva);
            formData.append('re', re);

            if (enviar) {
                $.ajax({
                    url: 'clientes_jquery.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $("#msn").html('<div class="text-center col-md-12 m-5"><div class="spinner-border avatar-lg text-primary m-2" role="status"></div></div>');
                    },
                    success: function (response) {
                        //$("#msn").html(response);

                        window.location.href = "clientes.php";
                    }
                });
            }
        });

        $("#canvas_img").on("mousedown", function (e) {
            console.log(e);
            console.log(e.y);
        })


        $("#btn_annadir_maquina").on("click", function () {
            cod_articulo = $("#modal_cod_articulo").val();
            nombre = $("#modal_nombre").val();
            ns = $("#modal_sn").val();
            descripcion = $("#modal_descripcion").val();
            cod_cliente = $("#modal_cod_cliente").val();
            cod_maquina = $("#modal_cod_maquina").val();

            $.ajax({
                url: 'add_maquina_cliente.php',
                type: 'post',
                data: "cod_articulo=" + cod_articulo + "&nombre=" + nombre + "&ns=" + ns + "&descripcion=" + descripcion + "&cod_cliente=" + cod_cliente + "&cod_maquina_modificar=" + cod_maquina,

                beforeSend: function () {
                    $("#msn").html('<div class="text-center col-md-12 m-5"><div class="spinner-border avatar-lg text-primary m-2" role="status"></div></div>');
                },
                success: function (response) {
                    $("#msn").html('');
                    $('#cerrar_modal').trigger('click');
                    window.location.reload();
                }
            });
        })

        $('#tabla_listado').DataTable({
            responsive: true,
            order: [[1, "asc"]],
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            }
        });


        $(".btn_eliminar").on("click", function () {
            codigo = $(this).attr("cod");
            if (confirm("Se va a eliminar la máquina. Confirmar?")) {
                $.ajax({
                    url: 'maquina_eliminar_jquery.php',
                    type: 'post',
                    data: "cod_maquina=" + codigo,
                    beforeSend: function () {
                    },
                    success: function (response) {
                        $("#reg_" + codigo).css("display", "none");
                    }
                });
            }
        });

        $(".btn_modificar").on("click", function () {
            cod_articulo = $(this).attr("cod_articulo");
            cod_maquina = $(this).attr("cod_maquina");
            nombre = $(this).attr("nombre");
            ns = $(this).attr("ns");
            desc = $(this).attr("desc");


            $("#modal_nombre").val(nombre);
            $("#modal_sn").val(ns);
            $("#modal_descripcion").val(desc);
            $("#modal_cod_articulo").val(cod_articulo);
            $("#modal_cod_maquina").val(cod_maquina);

            $("#select2modal h6").text('Modificar Máquina');
            $("#btn_annadir_maquina").text('Modificar');

        });

        $("#btn_modal_annadir_maquina").on("click", function () {
            $("#modal_nombre").val("");
            $("#modal_sn").val("");
            $("#modal_descripcion").val("");
            $("#modal_cod_articulo").val("");
            $("#modal_cod_maquina").val("");
        });


        $(".btn_revision").on("click", function () {
            cod = $(this).attr("cod_maquina");
            $("#cod_maquina").val(cod);
            $("#form_revisiones").submit();
        });

    </script>
</body>

</html>