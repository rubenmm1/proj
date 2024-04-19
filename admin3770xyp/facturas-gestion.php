<?php
@session_start();
if (!isset ($_SESSION['cod_usuario'])) {
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

if (isset ($_POST['cod_factura'])) {
	$albaranmodificar = true;
	$cod_factura = $_POST['cod_factura'];
	$sql = "select * from facturas
	where cod_factura='" . $cod_factura . "'";

	$resultP = $conexion->query($sql);
	while ($filaP = $resultP->fetch_assoc()) {
		$id_cliente = $filaP['id_cliente'];
		$fecha_albaran = formatearfecha($filaP['fecha']);
		$pagado = $filaP['pagado'];
		$observaciones = $filaP['observaciones'];

		if ($pagado <> "") {
			$facturado = true;
		} else {
			$facturado = false;
		}

		
		$titulo = $cod_factura;


		$t_pagos_valor = $filaP['tiempos_pago_valor'];
		$t_pagos_texto = $filaP['tiempos_pago_texto'];

		$tarifa = $filaP['tarifa'];
		$iva = $filaP['iva'];
		$re = $filaP['re'];

		$importe_descuento = $filaP['importe_descuento'];

		$total_factura_impuestos = $importe_descuento + ($importe_descuento * ($iva + $re) / 100);
	}

} else {
	$albaranmodificar = false;
	$titulo = "Nuevo";
	$cod_factura = 0;
}

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



<!--Internal Notify -->
<link href="../assets/plugins/notify/css/notifIt.css" rel="stylesheet" />

<!--- Animations css-->
<link href="../assets/css/animate.css" rel="stylesheet">

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
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Facturas</h4><span
								class="text-muted mt-1 tx-13 ms-2 mb-0">/
								<?php echo $titulo; ?>
							</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->

				<div class="row row-sm">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">FACTURA</h1>
										<a href="#" class="btn btn-success float-end m-2"
											onclick="javascript:window.history.back();">
											<i class="fa fa-reply"></i> Volver
										</a>

									</div><!-- invoice-header -->
									<div class="row">
										<div class="col-6" style='display:none'>
											<label>Cliente</label>
											<select class="js-example-basic-single js-states form-control"
												name="combo_cliente" id="combo_cliente">
												<option></option>
												<?php
												$sqlC = "select * from clientes where activo=1 order by nombre asc";
												$resultC = $conexion->query($sqlC);
												while ($filaC = $resultC->fetch_assoc()) {
													if ($filaC['cod_cliente'] == $id_cliente) {
														echo "<option selected value='" . $filaC['cod_cliente'] . "'>" . $filaC['razon_social'] . "</option>";
													} else {
														echo "<option value='" . $filaC['cod_cliente'] . "'>" . $filaC['razon_social'] . "</option>";
													}

												}
												?>
											</select>
										</div>

									</div>
									<div class="row mg-t-20">
										<div class="col-md-8">
											<label class="tx-gray-600">Facturado a</label>
											<div class="billed-to">
												<h6 id="p_a_razon_social"></h6>
												<p id="p_a_direccion">
												<p>
												<p id="p_a_telefono"></p>
												<p id="p_a_email"></p>

											</div>
										</div>
										<?php
										if ($albaranmodificar) {
											echo '
												<div class="col-md">
													<label class="tx-gray-600">Información la factura</label>
													<p class="invoice-info-row"><span>Nº Factura</span> <span><strong>' . $cod_factura . '</strong></span></p>
													<p class="invoice-info-row"><span>Fecha</span> <span>' . $fecha_albaran . '</span></p>
													<p class="invoice-info-row"><span>Pagada:</span> <span>' . $pagado . '</span></p>
												</div>';

										}
										?>

									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-20p">Articulo</th>
													<th class="wd-50p">Descripcion</th>
													<th class="tx-center wd-10p">Cantidad</th>
													<th class="tx-right wd-15p">Precio</th>
													<th class="tx-center wd-5p">Dto(%)</th>
													<th class="tx-right wd-15p">Subtotal</th>
													<!--
														<th class="wd-5p"></th>
														<th class="wd-5p"></th>
													-->
												</tr>
											</thead>
											<tbody id='lineas_factura'>
											</tbody>
											<tbody>

												<tr>
													<td class="valign-middle" colspan="3" rowspan="7">
														<label>Tiempos de pago</label>
														<p><small>
																<?php echo $signo . $t_pagos_texto; ?>
															</small></p>

													</td>
												<tr>
													<td class="tx-right">Dto.Tarifa</td>
													<td class="tx-right" colspan="2"><span id='tarifa_cliente'>
															<?php echo $tarifa; ?>
														</span> %</td>
												</tr>
												<tr>
													<td class="tx-right">Tiempos de pago</td>
													<?php
													if ($t_pagos_valor > 0) {
														$signo = "+";
													} else {
														$signo = "";
													}
													?>
													<td class="tx-right" colspan="2"><span id='t_pago'>
															<?php echo $signo . $t_pagos_valor; ?>
														</span> %</td>
												</tr>

												<td class="tx-right h5">Sub-Total</td>
												<td class="tx-right h5" colspan="2" id='txt_subotal_albaran'>0.00 €</td>
												</tr>

												<tr>
													<td class="tx-right">IVA (<span id='iva_cliente'></span>%)</td>
													<td class="tx-right" colspan="2" id='txt_iva_albaran'>0.00 €</td>
												</tr>
												<tr>
													<td class="tx-right">R.E. (<span id='re_cliente'></span>%)</td>
													<td class="tx-right" colspan="2" id='txt_re_albaran'>0.00 €</td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">Total</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold" id='txt_total_albaran'>0.00 €
														</h4>
													</td>
												</tr>
											</tbody>
										</table>
										<h6 class='pt-3'>Observaciones</h6>
										<textarea id=observaciones name=observaciones rows=4
											style='width:100%;border:none;background-color:#edecec;font-size:13px;padding:10px;'><?php echo $observaciones; ?></textarea>
									</div>
									<hr class="mg-b-40">
									<input type='hidden' id='cod_albaran' value='<?php echo $cod_factura; ?>' />
									<!--
										<a class="btn btn-purple float-end mt-3 ms-2" href="">
											<i class="mdi mdi-currency-usd me-1"></i>Pay Now
										</a>
									-->
									<a href="#" class="btn btn-danger float-end mt-3 ms-2"
										onclick="javascript:window.print();">
										<i class="mdi mdi-printer me-1"></i>Imprimir
									</a>

									<bottom class="btn btn-primary float-end mt-3 ms-2" id="btn_restificar" cod=<?php echo $cod_factura; ?>>
										<i class="fa fa-copy"></i> Rectificar
									</bottom>
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>

				<div class="row row-sm">
					<div class="col-xl-6 col-lg-6 col-md-12 ">
						<div class="card p-2">
							<div class="card-header">
								<label>Pagos</label>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-invoice border text-md-nowrap mb-0">
										<thead>
											<tr>
												<th class="tx-right wd-25p">Importe</th>
												<th class="tx-center wd-25p">Fecha</th>
												<th class="tx-center wd-25p">Tipo</th>
												<th class="tx-center wd-10p"></th>
											</tr>
										</thead>
										<tbody id=tb_pagos>
											<?php
											$total_pagado = 0;
											$sql = "select * from pagos p
												inner join tipo_pago tp on p.id_tipo_pago=tp.cod_tipo_pago
												where id_factura='" . $cod_factura . "'";

											$resultado_pagos = $conexion->query($sql);
											while ($fila_p = $resultado_pagos->fetch_assoc()) {
												echo "<tr id='linea_pago_" . $fila_p['cod_pago'] . "'>
													<td class='tx-right bold'>" . $fila_p['pago'] . " €</td>
													<td class='tx-center'>" . formatearfecha($fila_p['fecha']) . "</td>
													<td class='tx-center small'>" . $fila_p['descripcion'] . "</td>
													<td class='tx-center tx-bold'><i class='fa fa-trash btn_eliminar_pago text-danger puntero' cod='" . $fila_p['cod_pago'] . "' cod_factura='" . $cod_factura . "' ></i></td>
													</tr>";
												$total_pagado = $total_pagado + floatval($fila_p['pago']);
											}

											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xl-6 col-lg-6 col-md-12">
						<div class="card p-2">
							<div class="card-header p-2">
								<label>Nuevo pago</label>
							</div>
							<div class="card-body p-2">
								<?php
								$debe = number_format(floatval($total_factura_impuestos) - floatval($total_pagado), 2, '.', '');
								//echo $debe ;
								if ($debe < 0) {
									$debe = 0;
								}
								?>
								<div class='row'>
									<div class='col-6'>
										<label>Formas de pago</label>

										<select class='form-control' id=tipo_pago>
											<?php
											$sql_t = "select * from tipo_pago order by descripcion asc";
											$resul_t = $conexion->query($sql_t);

											while ($filaT = $resul_t->fetch_assoc()) {
												echo "<option value='" . $filaT['cod_tipo_pago'] . "'>" . $filaT['descripcion'] . "</option>";
											}

											?>
										</select>
									</div>
									<div class='col-6'>
										<label>Importe</label>
										<input type="number" min=0 class='form-control' id='txt_importe'
											value='<?php echo $debe; ?>' />
									</div>
									<div class='col-12 pt-3'>
										<?php
										if ($debe == 0) {
											echo "<div class='btn btn-success disabled btn-block' id='btn_pagar'>Pagar</div>";
										} else {
											echo "<div class='btn btn-success btn-block' id='btn_pagar'>Pagar</div>";
										}

										?>

									</div>
								</div>


							</div>
						</div>
					</div>
				</div>


				<div class="row row-sm" style="display:none">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card">
							<div class="card-body p-2">
								<div class="input-group">
									<div class='col-md-6'>
										<label>Categoria</label>
										<select class="js-example-basic-single js-states form-control"
											name="combo_cliente" id="combo_categoria">
											<option></option>
											<?php
											$sqlC = "select * from categorias where activo=1 order by nombre_categoria asc";
											$resultC = $conexion->query($sqlC);
											while ($filaC = $resultC->fetch_assoc()) {
												echo "<option value='" . $filaC['cod_categoria'] . "'>
														" . $filaC['nombre_categoria'] . "</option>";
											}
											?>
										</select>
									</div>
									<div class='col-md-6'>
										<label>Nombre/descripcion</label>
										<div class="input-group">
											<input type="text" id="txt_buscar" class="form-control"
												placeholder="Busquda ...">
											<span class="input-group-text p-0">
												<button class="btn btn-primary" id="btn_buscar"
													type="button">Buscar</button>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row row-sm" id='resultado'>
						</div>
					</div>

				</div>
			</div>
			<!--  -->
			<div style='display:none;' id='btn_mostrar_modal' class="btn ripple btn-primary"
				data-bs-effect="effect-scale" data-bs-target="#modaldemo1" data-bs-toggle="modal" href=""></div>
			<!-- Container closed -->
			<!-- Basic modal -->
			<div class="modal fade effect-scale" style="display:none" id="modaldemo1">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Modificar</h6><button aria-label="Close" class="close"
								data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>

						<div class="modal-body">
							<div class=row>
								<div class="col-12 pt-2">
									<h6 id="modal_nombre"></h6>
									<label>Descripcion</label>
									<textarea id='modal_descripcion' rows=5 style='width:100%;'></textarea>
								</div>
								<div class="col-4 pt-2 text-center">
									<label>Precio U.</label><br />
									<p id='modal_precio_u'> </p>
								</div>
								<div class="col-4 pt-2 text-center">
									<label>Cantidad</label><br />
									<input style='width:45px;' type=number id="modal_cantidad" maxlength="1" max=999
										min=1 />
								</div>
								<div class="col-4 pt-2 text-center">
									<label>Subtotal</label><br />
									<h4 id='modal_subtotal'> </h4>
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<input type=hidden id=modal_cod_articulo />
							<button class="btn ripple btn-primary" id='modal_btn_guardar' type="button">Guardar</button>
							<button class="btn ripple btn-secondary" id='modal_btn_cerrar' data-bs-dismiss="modal"
								type="button">Cerrar</button>
						</div>
					</div>
				</div>
			</div>
			<!-- End Basic modal -->
		</div>
		<!-- main-content closed -->

		<!-- Sidebar-right-->
		<?php
		//include("sidebar.php");
		?>
		<!--/Sidebar-right-->

		<!-- Footer opened -->
		<?php


		include ("footer.php");
		?>
		<!-- Footer closed -->

	</div>
	<!-- End Page -->

	<!-- Back-to-top -->
	<a href="#resultado" id="back-to-top"><i class="las la-angle-double-up"></i></a>

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

	<!--Internal  Datatable js -->
	<script src="../assets/js/table-data.js"></script>


	<!--Internal  Notify js -->
	<script src="../assets/plugins/notify/js/notifIt.js"></script>

	<!-- Internal Select2.min js -->
	<script src="../assets/plugins/select2/js/select2.min.js"></script>


	<!-- Internal form-elements js -->
	<script src="../assets/js/form-elements.js"></script>


	<!-- <script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>-->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- custom js -->
	<script src="../assets/js/custom.js"></script>
	<script>

		$('.js-example-basic-single').select2({
			placeholder: 'Elija una opcion'
		});

		var arrayArticulos = new Array();/// Variable global que guarda los articulos añadidos

		function msn() {
			notif({
				msg: "<b>Añadido:</b> El articulo ha sido añadido correctamente",
				type: "success"
			});
		}

		$(document).on('click', '.btn_modificar', function () {

			cod_articulo = $(this).attr("cod");
			precio_uni = $(this).attr("precio_uni");

			$('#modal_cod_articulo').val(cod_articulo);

			$('#modal_nombre').html($('#txt_nombre_' + cod_articulo).html())
			$('#modal_descripcion').val($('#txt_descripcion_' + cod_articulo).html())
			$('#modal_cantidad').val($('#txt_cantidad_cod_ant_' + cod_articulo).html())

			subtotal = $('#txt_subtotal_' + cod_articulo).html().slice(0, -2)
			$('#modal_subtotal').html(subtotal)

			precio_uni = $('#txt_precio_uni_' + cod_articulo).html().slice(0, -2)



			$('#modal_precio_u').html(precio_uni)

			$('#modal_cantidad').attr('cod', cod_articulo);
			$('#modal_cantidad').attr('precio_uni', precio_uni);


			$("#btn_mostrar_modal").trigger("click");

			/*
				$("#txt_cantidad_cod_"+codigo).css("display","block");
				$("#txt_cantidad_cod_"+codigo).focus();
				$("#txt_cantidad_cod_ant_"+codigo).css("display","none");
			*/

		})

		$("#modal_btn_guardar").on("click", function () {
			codigo = $('#modal_cod_articulo').val();
			descripcion = $('#modal_descripcion').val()


			$("#txt_descripcion_" + codigo).html(descripcion)
			$("#txt_cantidad_cod_ant_" + codigo).html($('#modal_cantidad').val())

			$("#txt_subtotal_" + codigo).html($('#modal_subtotal').html() + " €")


			arrayArticulos[codigo][0] = $('#modal_cantidad').val();//cantidad
			arrayArticulos[codigo][2] = descripcion;//descripcion
			console.log(arrayArticulos);
			SumarTotal();


			$("#modal_btn_cerrar").trigger("click");


		})

		$(document).on('change', '#modal_cantidad', function () {
			codigo = $(this).attr("cod");
			precio_uni = $(this).attr("precio_uni");
			valor = $(this).val()
			$('#modal_subtotal').html(precio_uni * valor)

			/*
			$("#txt_cantidad_cod_"+codigo).css("display","none");
			$("#txt_cantidad_cod_ant_"+codigo).html($(this).val())
			$("#txt_cantidad_cod_ant_"+codigo).css("display","block");
			*/

			//$("#txt_subtotal_"+codigo).html($(this).val()*precio_uni)


		})


		/*
				$(".btn_eliminar").on("click",function(){
					codigo = $(this).attr("cod");
					if(confirm("Se va a eliminar cliente. Confirmar?")){
						$.ajax({
							url: 'clientes_eliminar_jquery.php',
							type: 'post',
							data: "cod_cliente="+codigo,
							beforeSend: function() {
							},
							success: function(response) {
								$("#reg_"+codigo).css("display","none");
							}
						});
		
					}
				});
		*/
		/*
				$("#btn_buscar").on("click",function(){
					buscar= $("#txt_buscar").val();
					$.ajax({
						url: 'articulos_filtro_jquery.php',
						type: 'post',
						data: "busqueda="+buscar,
						beforeSend: function() {
							$("#resultado").html('<div class="spinner-grow text-center" role="status"><span class="sr-only">Loading...</span></div>');
						},
						success: function(response) {
							$("#resultado").html(response);
						}
					});
				})
		
				$("#btn_buscar").trigger("click");
		*/
		/*
				$(document).on( 'click', '.adtocart', function(){
					guardar=false;
					cod_articulo = $(this).attr("cod_articulo")
					cantidad=$("#cant_"+cod_articulo).val();
					yaexiste=false;
					//alert(arrayArticulos.length)
					if(arrayArticulos.length==0){
						guardar=true;
					}else{
						arrayArticulos.forEach( function(valor, indice, array) {
								if(indice==cod_articulo && valor[0]!=0){
									yaexiste=true;
								}
						});
		
						if(yaexiste){
							alert("Ya existe el articulo")
							guardar=false;
						}else{
							guardar=true;
						}
		
					}
		
					if(guardar){
						if(cantidad<=0){
							alert("Debes añadir una cantidad correcta")
						}else{
							nombre=$(this).attr("nombre");
							descripcion = $(this).attr("descripcion");
		
							precio_uni=$(this).attr("precio");
							subtotal = cantidad * precio_uni;
							//alert($("#cant_"+cod_articulo).val())
							$("#lineas_factura").append('<tr id="linea_presu_'+cod_articulo+'" ><td id="txt_nombre_'+cod_articulo+'">'+nombre+'</td><td id="txt_descripcion_'+cod_articulo+'"></td><td class="tx-center"><div id="txt_cantidad_cod_ant_'+cod_articulo+'">'+cantidad+'</div><input style="display:none;" cod="'+cod_articulo+'" id="txt_cantidad_cod_'+cod_articulo+'" type=number maxlength="1" min="1" max="999" value='+cantidad+' precio_uni="'+precio_uni+'" class="txt_cantidad_modificar"/></td><td class="tx-right" id="txt_precio_uni_'+cod_articulo+'">'+precio_uni+' €</td><td class="tx-right" id="txt_subtotal_'+cod_articulo+'">'+subtotal+' €</td><td class="tx-center"><i class="fa fa-edit btn_modificar" cod="'+cod_articulo+'"></i></td><td class="tx-center"><i class="far fa-trash-alt btn_eliminar_linea" cod='+cod_articulo+'></i></td></tr>')
							$("#back-to-top").trigger("click");
							msn();
							$arrayArt=new Array(2);
							$arrayArt[0]=cantidad;//cantidad
							$arrayArt[1]=precio_uni;//precio_unitario
							$arrayArt[2]='';//descripcion
		
							//arrayArticulos.push($arrayArt);
							arrayArticulos[cod_articulo]=$arrayArt;
		
							//console.log(arrayArticulos);
							SumarTotal();
						}
		
					}
		
				})
		*/

		$(document).on('click', '.btn_eliminar_pago', function () {
			codigo = $(this).attr("cod")
			codigo_factura = $(this).attr("cod_factura")
			if (confirm("Deseas eliminar el pago?")) {

				$.ajax({
					url: 'del_pago.php',
					type: 'post',
					data: "cod_pago=" + codigo + "&cod_factura=" + codigo_factura,
					beforeSend: function () {
					},
					success: function (response) {
						debe = parseFloat(response);
						debe = debe.toFixed(2);
						$("#btn_pagar").removeClass("disabled");
						$("#txt_importe").val(debe);
						$("#linea_pago_" + codigo).remove();

					}
				})//ajax

			}

		})

		function SumarTotal() {
			sumatorio = 0;

			arrayArticulos.forEach(function (valor, indice, array) {

				subtotalinea = parseFloat(valor[0] * valor[1]);
				dto = parseFloat(valor[3]);
				subtotalinea = subtotalinea - (subtotalinea * dto / 100);
				sumatorio = sumatorio + subtotalinea;
				//sumatorio=sumatorio + parseFloat(valor[0]*valor[1]);
			});


			dto_tarifa = $("#tarifa_cliente").html();
			t_pago = $("#t_pago").html();
			descuentos = t_pago - dto_tarifa;

			sumatorio = sumatorio + (sumatorio * descuentos / 100);

			tipo_iva = $("#iva_cliente").html();
			$("#txt_subotal_albaran").html(sumatorio.toFixed(2) + " €");
			iva = sumatorio * tipo_iva / 100;
			$("#txt_iva_albaran").html(iva.toFixed(2) + " €");
			tipo_re = $("#re_cliente").html();
			re = sumatorio * tipo_re / 100;
			$("#txt_re_albaran").html(re.toFixed(2) + " €");
			total = sumatorio + iva + re;
			$("#txt_total_albaran").html(total.toFixed(2) + " €");

		}

		$("#combo_cliente").on("change", function () {
			codigo = $(this).val();

			$.ajax({
				url: 'datos_cliente_jquery.php',
				type: 'post',
				data: "codigo=" + codigo,
				success: function (response) {
					arraydatos = response.split("####")
					$("#p_a_razon_social").html(arraydatos[0]);
					$("#p_a_direccion").html(arraydatos[1]);
					$("#p_a_telefono").html(arraydatos[2]);
					$("#p_a_email").html(arraydatos[3]);
					$("#iva_cliente").html(arraydatos[4]);
					$("#re_cliente").html(arraydatos[6]);
					SumarTotal()
				}
			});

		})



		$("#btn_pasar_a_factura").on("click", function () {
			codigo = $(this).attr('cod');

			swal({
				title: "Facturar",
				text: "Se va a facturar, deseas hacerlo?",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes",
				cancelButtonText: "No",
				closeOnConfirm: false,
				closeOnCancel: false
			},
				function (isConfirm) {
					if (isConfirm) {
						$.ajax({
							url: 'albaran_a_factura.php',
							type: 'post',
							data: "cod_albaran=" + codigo,
							beforeSend: function () {
							},
							success: function (response) {
								swal(" Factura " + response + " creada!", "Se ha facturado.", "success");
								window.location.href = "facturas.php";
							}
						})//ajax
					} else {
						swal("Cancelado", "Se ha cancelado", "error");
					}
				});
		})

		<?php
		/*************************/
		/* MODIFICAR Factura     */
		/*************************/

		//if($albaranmodificar){
		$cod_factura = $_POST['cod_factura'];

		$sql = "select p.descripcion as descripcionLinea, p.*, a.*  from facturas_lineas p
inner join articulos a on p.id_articulo=a.cod_articulo
where p.id_factura='" . $cod_factura . "'";
		//echo $sql;
		$result = $conexion->query($sql);
		$i = 0;
		while ($fila = $result->fetch_assoc()) {
			$descripcionLinea = str_replace(array("\r\n", "\n", "\r"), '\r', $fila['descripcionLinea']);
			?>
			$("#lineas_factura").append('<tr id="linea_presu_<?php echo $fila['cod_articulo']; ?>" ><td id="txt_nombre_<?php echo $fila['cod_articulo']; ?>"><?php echo $fila['nombre']; ?></td><td id="txt_descripcion_<?php echo $fila['cod_articulo']; ?>"><?php echo $descripcionLinea; ?></td><td class="tx-center"><div id="txt_cantidad_cod_ant_<?php echo $fila['cod_articulo']; ?>"><?php echo $fila['cantidad']; ?></div><input style="display:none;" cod="<?php echo $fila['cod_articulo']; ?>" id="txt_cantidad_cod_<?php echo $fila['cod_articulo']; ?>" type=number maxlength="1" min="1" max="999" value=<?php echo $fila['cantidad']; ?> precio_uni="<?php echo $fila['precio_unitario']; ?>" class="txt_cantidad_modificar"/></td><td class="tx-right" id="txt_precio_uni_<?php echo $fila['cod_articulo']; ?>"><?php echo $fila['precio_unitario']; ?> €</td>      <td class="tx-center" id="txt_desc_<?php echo $fila['cod_articulo']; ?>"><?php echo $fila['desc_linea']; ?></td>        <td class="tx-right" id="txt_subtotal_<?php echo $fila['cod_articulo']; ?>"><?php echo $fila['subtotal']; ?> €</td></td></tr>')

			$arrayArt = new Array(2);
			$arrayArt[0] = '<?php echo $fila['cantidad']; ?>';//cantidad
			$arrayArt[1] = '<?php echo $fila['precio_unitario']; ?>';//precio_unitario
			$arrayArt[2] = '<?php echo $descripcionLinea; ?>';//descripcion
			$arrayArt[3] = '<?php echo $fila['desc_linea']; ?>';//descuento linea
			$arrayArt[4] = '<?php echo $fila['cod_articulo']; ?>';//codigo del articulo

			//arrayArticulos.push($arrayArt);
			arrayArticulos[<?php echo $i; ?>] = $arrayArt;

			<?php
			$i++;
		}
		?>

		$("#combo_cliente").trigger("change");
		SumarTotal()

		$("#btn_pagar").on("click", function () {
			tipo = $("#tipo_pago").val();
			tipo_texto = $("#tipo_pago option:selected").text();

			importe = $("#txt_importe").val();
			codigo = '<?php echo $cod_factura; ?>';
			if (importe == "") {
				alert("Debes introducir ")
			} else {
				$.ajax({
					url: 'add_pago.php',
					type: 'post',
					data: "cod_factura=" + codigo + "&cod_tipo=" + tipo + "&importe=" + importe,
					beforeSend: function () {
					},
					success: function (response) {
						arrayresponse = response.split("#####");
						debe = parseFloat(arrayresponse[0]);
						debe = debe.toFixed(2);
						cod_pago = arrayresponse[1];

						swal.fire("Pago añadido!", "", "success");


						var d = new Date();
						var mm = d.getMonth() + 1;
						var dd = d.getDate();
						var yy = d.getFullYear();

						if (mm < 10) {
							mm = "0" + mm
						}
						if (dd < 10) {
							dd = "0" + dd
						}

						var fecha = dd + '-' + mm + '-' + yy;
						$("#tb_pagos").append("<tr id='linea_pago_" + cod_pago + "'><td class='tx-right bold'>" + importe + " €</td><td class='tx-center'>" + fecha + "</td><td class='tx-center small'>" + tipo_texto + "</td><td class='tx-center tx-bold'><i class='fa fa-trash btn_eliminar_pago text-danger puntero' cod=" + cod_pago + " cod_factura='<?php echo $cod_factura; ?>' ></i></td></tr>")


						if (debe <= 0) {
							$("#txt_importe").val('0');
							$("#btn_pagar").addClass("disabled");
						} else {
							$("#txt_importe").val(debe);
						}

					}
				})//ajax
			}

		})

		$("#btn_restificar").on("click", function () {
			factura = $(this).attr('cod');

			/* Se controla si hay algun pago realizado */
			total = $("#txt_total_albaran").html();
			arraytotal = total.split(" ");
			if ($("#txt_importe").val() < parseFloat(arraytotal[0])) {
				swal.fire("Hay pagos!", "Debes eliminar los pagos antes de crear la factura rectificativa.", "danger");
			} else {
				swal.fire({
					title: "Rectificativa",
					text: "Se va a crear una factura rectificativa de esta factura, deseas hacerlo?",
					type: "warning",
					//showCancelButton: true,
					showDenyButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Si",
					//cancelButtonText: "No",
					closeOnConfirm: false,
					closeOnCancel: false
				}).then((result) => {
					/* Read more about isConfirmed, isDenied below */
					if (result.isConfirmed) {
						$.ajax({
							url: 'factura_a_restificativa.php',
							type: 'post',
							data: "cod_factura=" + factura,
							beforeSend: function () {
							},
							success: function (response) {
								$("#observaciones").val(response)
							}
						})//ajax

					}
				})
			}//else
		});
	</script>
</body>

</html>