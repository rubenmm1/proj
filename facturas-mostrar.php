<?php
@session_start();
if (!isset($_SESSION['cod_cliente']))
{
	header("location: index.php");
}

include ("conexion.php");
include ("functions.php");

if(isset($_POST['cod_factura'])){

	$cod_factura = $_POST['cod_factura'];
	$sql="select * from facturas p
	inner join clientes c on c.cod_cliente=p.id_cliente
	where cod_factura='".$cod_factura."'";

	$resultP = $conexion->query($sql);
	while($filaP = $resultP->fetch_assoc()){
			$id_cliente=$filaP['id_cliente'];
			$fecha_presupuesto=formatearfecha($filaP['fecha']);
			$N_albaran=$filaP['albaran'];
			$observaciones = $filaP['observaciones'];

			$razon_social = $filaP['razon_social'];
			$direccion = $filaP['direccion'].",".$filaP['poblacion'].",".$filaP['provincia'].",".$filaP['cp'];
			$telefono = $filaP['telefono'];
			$email = $filaP['email'];

			$tarifa=$filaP['tarifa'];
			$iva_cliente=$filaP['iva'];
			$re_cliente=$filaP['re'];

			$titulo = $filaP['cod_factura'];

			$pagada=$filaP['pagado'];
			$albaran=$filaP['albaran'];
			$tiempo_pagos_texto = $filaP['tiempos_pago_texto'];
			$tiempo_pagos_valor = $filaP['tiempos_pago_valor'];
	}


}else{
	$presupuestomodificar=false;
	$titulo = "Nuevo";
	$cod_presupuesto = 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<!-- Internal Data table css -->
<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="assets/plugins/datatable/css/buttons.bootstrap5.min.css" rel="stylesheet">
<link href="assets/plugins/datatable/responsive.bootstrap5.css" rel="stylesheet" />
<link href="assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="assets/plugins/datatable/responsive.dataTables.min.css" rel="stylesheet">
<link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet">
<!--- Internal Sweet-Alert css-->
<link href="assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">



<!--Internal Notify -->
<link href="assets/plugins/notify/css/notifIt.css" rel="stylesheet" />

<!--- Animations css-->
<link href="assets/css/animate.css" rel="stylesheet">

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
							<div class="d-flex"><h4 class="content-title mb-0 my-auto">Factura</h4><span class="text-muted mt-1 tx-13 ms-2 mb-0">/ <?php echo $titulo;?></span></div>
						</div>
					</div>
					<!-- breadcrumb -->

					<div class="row row-sm">
						<div class="col-md-12 col-xl-12">
							<div class=" main-content-body-invoice">
								<div class="card card-invoice">
									<div class="card-body">
										<div class="invoice-header">
											<h1 class="invoice-title text-left">FACTURA</h1>
											<a href="#" class="btn btn-success text-right  m-2"  onclick="javascript:window.history.back();">
												<i class="fa fa-reply"></i> Volver
											</a>


										</div><!-- invoice-header -->

										<div class="row mg-t-20">
											<div class="col-md-8">
												<label class="tx-gray-600">Facturado a</label>
												<div class="billed-to">
													<h6><?php echo $razon_social;?></h6>
													<p><?php echo $direccion;?><p>
													<p ><?php echo "Tel: ".$telefono;?></p>
													<p><?php echo "Email: ".$email;?></p>
												</div>
											</div>

											<?php
											if($pagada){
												$pagada="<span class='badge bg-success text-white'>Pagada</span>";
											}else{
												$pagada="<span class='badge bg-danger  text-white'>Pendiente</span>";
											}
											 echo '<div class="col-md">
													<label class="tx-gray-600">Información de la factura</label>
													<p class="invoice-info-row"><span>Nº Factura</span> <span><strong>'.$cod_factura.'</strong></span></p>
													<p class="invoice-info-row"><span>Fecha</span> <span>'.$fecha_presupuesto.'</span></p>
													<p class="invoice-info-row"><span>Pagada:</span> <span>'.$pagada.'</span></p>
												</div>';
											?>

										</div>
										<div class="table-responsive mg-t-40">
											<table class="table table-invoice border text-md-nowrap mb-0">
												<thead>
													<tr>
														<th class="wd-20p">Articulo</th>
														<th class="wd-55p">Descripcion</th>
														<th class="tx-center wd-10p">Cantidad</th>
														<th class="tx-right wd-20p">Precio</th>
														<th class="tx-center wd-5p">Dto(%)</th>
														<th class="tx-right wd-15p">Subtotal</th>
													</tr>
												</thead>
												<tbody>
													<?php

													$sql="select a.*, p.*, p.descripcion as descripcion_linea from facturas_lineas p
													inner join articulos a on a.cod_articulo=p.id_articulo
													where id_factura='".$cod_factura."'";

													$result=$conexion->query($sql);
													$subtotal=0;
													while($fila=$result->fetch_assoc()){
														echo '
														<tr  >
															<td >'.$fila['nombre'].'</td>
															<td >'.$fila['descripcion_linea'].'</td>
															<td class="tx-center">'.$fila['cantidad'].'</td>
															<td class="tx-right">'.$fila['precio_unitario'].' €</td>
															<td class="tx-center">'.$fila['desc_linea'].'</td>
															<td class="tx-right">'.$fila['subtotal'].' €</td>
														</tr>';
														$subtotal= $subtotal+$fila['subtotal'];
													}
													?>
											 </tbody>
											 <tbody>

													<tr>
														<td class="valign-middle" colspan="3" rowspan="7">
															<small><strong>Tiempos de pagos</strong>
															<p>
															<?php echo $tiempo_pagos_texto;?>
														</p>
														</small>
														</td>
													</tr>
													<tr>
														<td class="tx-right">Dto.Tarifa</td>
														<td class="tx-right" colspan="2" >
															<?php echo $tarifa;?> %</td>
													</tr>
													<tr>
														<td class="tx-right">Tiempos de pago</td>
														<td class="tx-right" colspan="2" >
															<?php
																if($tiempo_pagos_valor>0){
																	$texto_tiempo_pagos_valor= "+".$tiempo_pagos_valor;
																}else{
																	$texto_tiempo_pagos_valor= $tiempo_pagos_valor;
																}
																echo $texto_tiempo_pagos_valor;
															?> %</td>
													</tr>
													<tr>
														<td class="tx-right h5">Sub-Total</td>
														<td class="tx-right h5" colspan="2">
															<?php
																$descuentos = $tiempo_pagos_valor-$tarifa;
																$subtotal_tarifa = $subtotal + ($subtotal*$descuentos/100);
																$subtotal_tarifa= number_format($subtotal_tarifa,2,".","");
																echo $subtotal_tarifa;
															?> €</td>
													</tr>
													<tr>
														<td class="tx-right">IVA (<?php echo $iva_cliente;?> %)</td>
														<td class="tx-right" colspan="2">
															<?php
																$iva_precio=$subtotal_tarifa*$iva_cliente/100;
																echo number_format($iva_precio,2,".","");
															?> €</td>
													</tr>
													<tr>
														<td class="tx-right">R.E. (<?php echo $re_cliente;?> %)</td>
														<td class="tx-right" colspan="2">
															<?php
																$re_precio=$subtotal_tarifa*$re_cliente/100;
																echo number_format($re_precio,2,".","");
															?> €</td>
													</tr>
													<tr>
														<td class="tx-right tx-uppercase tx-bold tx-inverse">Total</td>
														<td class="tx-right" colspan="2">
															<h4 class="tx-primary tx-bold" >
																<?php
																$precio_total= $subtotal_tarifa+$iva_precio+$re_precio;
																 echo number_format($precio_total,2,".","");
																 ?> €</h4>
														</td>
													</tr>
												</tbody>
											</table>
											<h6 class='pt-3'>Observaciones</h6>
											<div id=observaciones name=observaciones rows=4 style='height:100px;width:100%;border:none;background-color:#edecec;font-size:13px;padding:10px;'><?php echo $observaciones;?></div>
										</div>
										<hr class="mg-b-40">

										<a href="#" class="btn btn-danger float-end mt-3 ms-2"  onclick="javascript:window.print();">
											<i class="mdi mdi-printer me-1"></i>Imprimir
										</a>

									</div>
								</div>
							</div>
						</div><!-- COL-END -->
					</div>

				</div>
				<!--  -->

			</div>
			<!-- main-content closed -->

			<!-- Footer opened -->
			<?php
				include("footer.php");
			?>
			<!-- Footer closed -->

		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<a href="#resultado" id="back-to-top"><i class="las la-angle-double-up"></i></a>

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
		<script src="assets/plugins/perfect-scrollbar/p-scroll.js"></script>

		<!-- Rating js-->
		<script src="assets/plugins/rating/jquery.rating-stars.js"></script>
		<script src="assets/plugins/rating/jquery.barrating.js"></script>

		<!-- Custom Scroll bar Js-->
		<script src="assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!-- Horizontalmenu js-->
		<script src="assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>

		<!-- Sticky js -->
		<script src="assets/js/sticky.js"></script>

		<!-- Right-sidebar js -->
		<script src="assets/plugins/sidebar/sidebar.js"></script>
		<script src="assets/plugins/sidebar/sidebar-custom.js"></script>

		<!-- eva-icons js -->
		<script src="assets/js/eva-icons.min.js"></script>

		<!-- Internal Data tables -->
		<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatable/datatables.min.js"></script>
		<script src="assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
		<script src="assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
		<script src="assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
		<script src="assets/plugins/datatable/js/jszip.min.js"></script>
		<script src="assets/plugins/datatable/js/buttons.html5.min.js"></script>
		<script src="assets/plugins/datatable/js/buttons.print.min.js"></script>
		<script src="assets/plugins/datatable/js/buttons.colVis.min.js"></script>
		<script src="assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
		<script src="assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>

		<!--Internal  Datatable js -->
		<script src="assets/js/table-data.js"></script>


		<!--Internal  Notify js -->
		<script src="assets/plugins/notify/js/notifIt.js"></script>

		<!-- Internal Select2.min js -->
		<script src="assets/plugins/select2/js/select2.min.js"></script>


		<!-- Internal form-elements js -->
		<script src="assets/js/form-elements.js"></script>


		<!--<script src="assets/plugins/sweet-alert/sweetalert.min.js"></script>-->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<!-- custom js -->
		<script src="assets/js/custom.js"></script>
		<script>
		$("#btn_aceptar").on("click",function(){
			codigo = $(this).attr("cod");
			$.ajax({
				url: 'add_aceptar.php',
				type: 'post',
				data: "cod_presupuesto="+codigo+"&accion=aceptar",

				beforeSend: function() {
					$("#msn").html('<div class="text-center col-md-12 m-5"><div class="spinner-border avatar-lg text-primary m-2" role="status"></div></div>');
				},
				success: function(response) {
					//$("#msn").html(response);
					$("#btn_aceptar").css("display","none");
				}
			});
		})
		</script>
	</body>
</html>
