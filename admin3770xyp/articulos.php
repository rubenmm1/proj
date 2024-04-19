<?php
@session_start();
if (!isset($_SESSION['cod_usuario'])) {
	header("location: index.php");
}

include ("../conexion.php");
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
							<h4 class="content-title mb-0 my-auto">Artículos</h4>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->

				<div class="row row-sm">

					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0 text-right">
								<a href="articulos-gestion.php">
									<div class="btn btn-success">Nuevo Articulo</div>
								</a>
							</div>
							<div class="card-body">
								<div class="table-responsive hoverable-table">
									<table id="tabla_listado" class="table text-md-nowrap">
										<thead>
											<tr>
												<th></th>
												<th>Nombre</th>
												<th>Descripcion</th>
												<th>Precio</th>
												<th>Tipo</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sql = "select * from articulos where activo=1
												order by nombre asc";
											$result = $conexion->query($sql);
											if ($result->num_rows == 0) {// Usuario web no existente
												echo "no hay facturas";
											} else {// existe el usuario web
											
												while ($fila1 = $result->fetch_assoc()) {
													switch ($fila1['tipo']) {
														case 1:
															$tipo = "<span class='badge bg-info'>Maquina</span>";
															break;
														case 2:
															$tipo = "<span class='badge bg-success'>Incidencia</span>";
															break;
														case 3:
															$tipo = "<span class='badge bg-dark'>Material</span>";
															break;
														default:
															// code...
															break;
													}

													echo "
														<tr id='reg_" . $fila1['cod_articulo'] . "'>
															<td ><img style='max-height:50px' src='../fotos/" . $fila1['cod_articulo'] . "/" . $fila1['cod_articulo'] . ".jpg' class='img-fluid' /></td>
															<td class='tx-bold'>" . substr($fila1['nombre'], 0, 100) . "</td>
															<td class='text-left small'>" . substr($fila1['descripcion'], 0, 100) . " ...</td>
															<td class='text-right tx-bold'>" . $fila1['precio'] . " €</td>
															<td class='text-center'>" . $tipo . "</td>
															<td class='text-center  wd-5p'><i class='fa fa-edit btn_modificar puntero' cod=" . $fila1['cod_articulo'] . "></i>&nbsp;<i class='fa fa-trash btn_eliminar puntero tx-danger' cod=" . $fila1['cod_articulo'] . " ></i></td>
														</tr>";
												}
											}
											?>

										</tbody>
									</table>
									<form method="post" name='form_modificar' id="form_modificar"
										action="articulos-gestion.php">
										<input type=hidden name='cod_articulo' id='cod_articulo' />
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

	<!--Internal  Datatable js -->

	<!-- custom js -->
	<script src="../assets/js/custom.js"></script>
	<script>

		$('#tabla_listado').DataTable({
			responsive: true,
			order: [[1, "asc"]],
			language: {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			}
		});

		$(".btn_modificar").on("click", function () {
			codigo = $(this).attr("cod");
			$("#cod_articulo").val(codigo);
			$("#form_modificar").submit();
		})

		$(".btn_eliminar").on("click", function () {
			codigo = $(this).attr("cod");
			if (confirm("Se va a eliminar el articulo. Confirmar?")) {
				$.ajax({
					url: 'articulos_eliminar_jquery.php',
					type: 'post',
					data: "cod_articulo=" + codigo,
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