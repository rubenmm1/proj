<?php
@session_start();
if (!isset ($_SESSION['cod_usuario'])) {
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
<!--<link href="../assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
							<h4 class="content-title mb-0 my-auto">Facturas</h4>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->

				<div class="row row-sm">

					<div class="col-xl-12">
						<div class="card">
							<!--
								<div class="card-header pb-0 text-right">
									<div class="btn btn-success" id='btn_facturar'>Pasar a factura</div>
								</div>
							-->
							<div class="card-body">
								<div class="table-responsive hoverable-table">
									<table id="tabla_listado" class="table text-md-nowrap">
										<thead>
											<tr>
												<th class='text-center'>Facturas</th>
												<th>Cliente</th>
												<th data-orderable="false">Observaciones</th>
												<th class='text-center'>Fecha</th>
												<th class='text-right'>Importe</th>
												<th class='text-center'>Fac.</th>
												<th data-orderable="false"></th>

											</tr>
										</thead>
										<tbody>
											<?php
											$sql = "select * from facturas a
												inner join clientes c on c.cod_cliente= a.id_cliente
												order by fecha asc";
											$result = $conexion->query($sql);
											if ($result->num_rows == 0) {// Usuario web no existente
												echo "No hay clientes";
											} else {// existe el usuario web
												while ($fila1 = $result->fetch_assoc()) {
													$tipo_factura = substr($fila1['cod_factura'], 0, 1);
													if ($tipo_factura <> "R") {// factura
														if ($fila1['pagado'] <> 0) {
															$pagado = "<div class='badge bg-success'>Pagada</div>";
														} else {
															$pagado = "<div class='badge bg-danger btn_pasar_albaran puntero' cod='" . $fila1['cod_factura'] . "'>Pendiente</div>";
														}
													} else {// Restificativa
														$pagado = "<div class='badge bg-info'>Abono</div>";
													}

													echo
														"<tr id='reg_" . $fila1['cod_factura'] . "'>
														<td class=' text-center tx-bold wd-5p'>" . $fila1['cod_factura'] . "</td>
														<td class='tx-bold wd-20p'>" . $fila1['razon_social'] . " <small>(" . $fila1['cif'] . ")</small></td>
														<td class='small'>" . $fila1['observaciones'] . "</td>
														<td class='text-center wd-10p'>" . formatearfecha($fila1['fecha']) . "</td>
														<td class='text-right tx-bold wd-5p'>" . $fila1['importe_descuento'] . " €</td>
														<td class='text-center wd-10p'>" . $pagado . "</td>
														<td class='text-right  wd-5p'><i class='fa fa-eye btn_modificar puntero' cod=" . $fila1['cod_factura'] . "></i></td>
													</tr>";
												}
											}
											?>

										</tbody>
									</table>

									<form method="post" name='form_facturar' id="form_facturar"
										action="facturas-gestion.php">
										<input type=hidden name='cod_factura' id='cod_factura' />
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


	<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>


	<!-- custom js -->
	<script src="../assets/js/custom.js"></script>
	<script>

		$('#tabla_listado').DataTable({
			responsive: true,
			dom: 'Bfrtip',
			buttons: [
				'pdf'
			],
			order: [[0, "desc"]],
			language: {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			}
		});

		$(".btn_modificar").on("click", function () {
			codigo = $(this).attr("cod");
			$("#cod_factura").val(codigo);
			$("#form_facturar").submit();
		})

		$(".btn_eliminar").on("click", function () {
			codigo = $(this).attr("cod");
			if (confirm("Se va a eliminar el albarán. Confirmar?")) {
				$.ajax({
					url: 'albaran_eliminar_jquery.php',
					type: 'post',
					data: "cod_albaran=" + codigo,
					beforeSend: function () {
					},
					success: function (response) {
						$("#reg_" + codigo).css("display", "none");
					}
				});

			}
		});


	</script>
</body>

</html>