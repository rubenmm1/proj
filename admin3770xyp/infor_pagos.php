<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<!--- Internal Sweet-Alert css-->
<!--<link href="../assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">-->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
							<div class="d-flex"><h4 class="content-title mb-0 my-auto">Informes Pagos</h4></div>
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
									<div class="row pb-3 pt-3"><!-- panel de busqueda -->
										<div class="col-md-2">
											<label>Cliente</label>
											<input type="text" class="form-control" id='combo_cliente' />
										</div>
										<div class="col-md-2">
											<label>Factura</label>
											<input type="text" class="form-control" id='factura' />
										</div>

										<div class="col-md-2">
											<label>Desde</label>
											<input type="date" class="form-control" id=fecha_inicio value="<?php echo date("Y-m-d", strtotime("-1 months")); ?>" />
										</div>

										<div class="col-md-2">
											<label>Hasta</label>
											<input type="date" class="form-control" id=fecha_fin value="<?php echo date('Y-m-d'); ?>" />
										</div>

										<div class="col-md-2">
											<label>Tipo de Pago</label>
											<select id='sel_tipo_pago' class="form-control">
												<option value=""></option>
												<?php
												$sql="select * from tipo_pago order by descripcion asc";
												$res=$conexion->query($sql);
												while($fil=$res->fetch_assoc()){
													echo "<option value='".$fil['cod_tipo_pago']."'>".$fil['descripcion']."</option>";
												}
												?>
											</select>
										</div>

										<div class="col-md-2 text-right">
											<br />
											<div  class="btn btn-primary" id='btn_filtrar'/><i class="fas fa-filter"></i> filtrar</div>
										</div>

									</div>
									<hr />
									<div class="table-responsive hoverable-table">
										<table id="tabla_listado" class="table text-md-nowrap">
											<thead>
												<tr>
													<th class='text-center'>Pago</th>
													<th>Cliente</th>
													<th>Factura</th>
													<th >Fecha</th>
													<th >Tipo</th>
													<th class='text-right'>Importe</th>
												</tr>
											</thead>
											<tbody id="tabla_registros">
											</tbody>
										</table>
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


		<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>


		<!-- Internal Select2.min js -->
		<script src="../assets/plugins/select2/js/select2.min.js"></script>

		<!-- custom js -->
		<script src="../assets/js/custom.js"></script>

		 <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
		<script>
		$('.js-example-basic-single').select2({
			placeholder: 'Elija una opcion'
		});

		$(document).ready(function() {
			table= $('#tabla_listado').DataTable({
				dom: 'Bfrtip',
		    buttons: [
		        'excel',
				'pdf',
				'csv'
		    ],
				columnDefs: [
			    {
			        targets: 5,
			        className: 'dt-right'
			    },
					{
			        targets: 3,
			        className: 'dt-right'
			    },
					{
							targets: 4,
							className: 'dt-center'
					}
			  ],
				responsive: true,
				 order: [[ 0, "desc" ]],
				 language: {
	             "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	         }
			});

			$("#btn_filtrar").trigger("click");
		});


		$("#btn_filtrar").on("click",function(){
			cliente=$("#combo_cliente").val();
			f_desde=$("#fecha_inicio").val();
			f_hasta=$("#fecha_fin").val();
			tipo=$("#sel_tipo_pago").val();
			factura=$("#factura").val();

			$.ajax({
				url: 'filtrar_pagos_jquery.php',
				type: 'post',
				dataType: 'JSON',
				data: "cliente="+cliente+"&f_desde="+f_desde+"&f_hasta="+f_hasta+"&factura="+factura+"&tipo="+tipo,
				beforeSend: function() {
					table.clear().draw();
				},
				success: function(response) {
					table.rows.add(response).draw();
				}
			});
		})

//// Autocompletar Clientes

		var availableTags = [
			<?php
			$sqlC="select * from clientes where activo=1 order by nombre asc";
			$resultC = $conexion->query($sqlC);
			$i=0;
			while($filaC = $resultC->fetch_assoc()){
					if($i>0){
						echo ",";
					}
					echo "'".$filaC['razon_social']."'";
					$i++;
			}

			?>
		];
		$( "#combo_cliente" ).autocomplete({
      source: availableTags
    });

		</script>
	</body>
</html>
