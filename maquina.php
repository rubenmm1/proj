<?php
@session_start();
if (!isset($_SESSION['cod_cliente'])) {
	header("location: index.php");
}

if (!isset($_POST['txt_cod_maquina'])) {
	echo "Error de maquina introducida";
} else {
	include("conexion.php");

	$codigo_maquina = $_POST['txt_cod_maquina'];

	// Sacamos el número de incidencias y revisiones que tiene la máquina
	$sql = "select count(*) as cont from revisiones where id_maquina=" . $codigo_maquina;

	$contRevisiones = $conexion->query($sql)->fetch_assoc()['cont'];

	// Sacamos el numero de incidencias de esa máquina
	// Para ello necesitamos el codigo de las revisiones ya que las incidencias se hacen de cada revision

	$sqlInicidencias = "select COUNT(*) as cont FROM incidencias INNER JOIN revisiones ON cod_revision = id_revision WHERE revisiones.id_maquina=" . $codigo_maquina;

	$contIncidencias = $conexion->query($sqlInicidencias)->fetch_assoc()['cont'];

	/////a partir de aquí obtenemos los datos de las revisiones y las incidencias para mostrarlos en dos datatables

	$sqlDatosRev = "select * from revisiones where id_maquina=" . $codigo_maquina;
	$datosRev = $conexion->query($sqlDatosRev);

	$sqlDatosInc = "select inc.* from incidencias as inc inner join revisiones rev on cod_revision=id_revision where rev.id_maquina=" . $codigo_maquina;
	$datosInc = $conexion->query($sqlDatosInc);


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


					<?php
					$sql = "select * from maquinas m
					inner join articulos a on a.cod_articulo = m.id_articulo
					where m.cod_maquina=" . $codigo_maquina;
					$result = $conexion->query($sql);
					if ($result->num_rows == 0) { // Usuario web no existente
						echo "no hay maquinas";
					} else { // existe el usuario web
						while ($fila1 = $result->fetch_assoc()) {
							?>
							<!-- breadcrumb -->
							<div class="breadcrumb-header justify-content-between">
								<div class="my-auto">
									<div class="d-flex">
										<h4 class="content-title mb-0 my-auto">Home</h4><span
											class="text-muted mt-1 tx-13 ms-2 mb-0">/ Maquinas / <?php echo $fila1['nombre_maquina']; ?></span>
									</div>
								</div>
							</div>
							<!-- breadcrumb -->
							<div class="row row-sm">
								<div class="col-lg-4">
									<div class="card mg-b-20">
										<div class="card-body">
											<div class="ps-0">
												<div class="main-profile-overview">
													<div class="d-flex justify-content-between mg-b-20">
														<div>
															<h5 class="main-profile-name">
																<?php echo $fila1['nombre_maquina']; ?>
															</h5>
															<small>SN:<strong><?php echo $fila1['nserie']; ?></strong></small>
															<p class="main-profile-name-text">
																<?php echo $fila1['descripcion_maquina']; ?>
															</p>
														</div>
													</div>
													<?php
													echo '<img alt="" src="fotos/' . $fila1['id_articulo'] . '/' . $fila1['id_articulo'] . '.jpg"><a class="img-fluid" href="JavaScript:void(0);"></a>'
														?>
													<h6>Articulo</h6>
													<div class="main-profile-bio">
														<h6>
															<?php echo $fila1['nombre']; ?>
														</h6>
														<?php echo $fila1['descripcion']; ?>
													</div><!-- main-profile-bio -->


													<!-- <hr class="mg-y-30"> -->

												</div><!-- main-profile-overview -->
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-8">
									<div class="row row-sm">
										<div class="col-sm-12 col-xl-6 col-lg-12 col-md-12">
											<div class="card ">
												<div class="card-body">
													<div class="counter-status d-flex md-mb-0">
														<div class="counter-icon bg-primary-transparent">
															<i class="fa fa-wrench text-primary"></i>
														</div>
														<div class="ms-auto">
															<h5 class="tx-13">Número de revisiones</h5>
															<h2 class="mb-0 tx-22 mb-1 mt-1">
																<?php echo $contRevisiones ?>
															</h2>
															<!-- <p class="text-muted mb-0 tx-11"><i class="si si-arrow-up-circle text-success me-1"></i>increase</p> -->
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-12 col-xl-6 col-lg-12 col-md-12">
											<div class="card ">
												<div class="card-body">
													<div class="counter-status d-flex md-mb-0">
														<div class="counter-icon bg-danger-transparent">
														<i class="fa fa-clipboard text-32  text-orange "></i>
														</div>
														<div class="ms-auto">
															<h5 class="tx-13">Número de incidencias</h5>
															<h2 class="mb-0 tx-22 mb-1 mt-1"><?php echo $contIncidencias ?></h2>
															<!-- <p class="text-muted mb-0 tx-11"><i class="si si-arrow-up-circle text-success me-1"></i>increase</p> -->
														</div>
													</div>
												</div>
											</div>
										</div>

									</div>
									<div class="card">
										<div class="card-body">
											<div class="tabs-menu ">
												<!-- Tabs -->
												<ul class="nav nav-tabs profile navtab-custom panel-tabs">
													<li class="">
														<a href="#home" data-bs-toggle="tab" class=" active" aria-expanded="true">
															<span class="visible-xs"><i
																	class="fa fa-wrench tx-16 me-1"></i></span> <span
																class="hidden-xs">Revisiones</span> </a>
													</li>
													<li class="">
														<a href="#profile" data-bs-toggle="tab" aria-expanded="false"> <span
																class="visible-xs"><i class="fa fa-clipboard tx-15 me-1"></i></span>
															<span class="hidden-xs">Incidencias</span> </a>
													</li>

												</ul>
											</div>
											<div
												class="tab-content border-start border-bottom border-right border-top-0 p-4 br-dark">
												<div class="tab-pane active" id="home">
													<!-- <div class="card"> -->
														<div class="card-header">
															<h3 class="tx-15 text-uppercase mb-3">Histórico de revisiones</h3>
														</div>

														<div class="card-body">
															<div class="table-responsive hoverable-table overflow-hidden">
																<table id="tabla_listado" class="table text-md-nowrap">
																	<thead>
																		<tr>
																			<th>Fecha</th>
																			<th class="">Descripcion</th>
																			<th></th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php




																		if ($contRevisiones != 0) { //Hay revisiones                                            
																			while ($fila1 = $datosRev->fetch_assoc()):
																				

																				echo "
                                                            <tr id='reg_" . $fila1['cod_maquina'] . "'>                                                            
                                                            <td class='text-left tx-bold'>" .date('d-m-Y',strtotime($fila1['fecha']) )  . "</td>                                                            
                                                            <td class='text-left small'>" . $fila1['descripcion'] . "</td>                                                            
                                                            <td class='text-center wp-20'><i style='cursor:pointer' class='fa fa-eye btn_ver_revision' cod_maqui=" . $codigo_maquina . " cod_rev=" . $fila1['cod_revision'] . "></i></td>";
																				echo "</tr>";

																			endwhile;
																		} 
																		?>
																	</tbody>
																</table>
															</div>
														</div>
													<!-- </div> -->


												</div>
												<div class="tab-pane" id="profile">
													<!-- <div class="card"> -->
														<div class="card-header">
															<h3 class="tx-15 text-uppercase mb-3">Histórico de incidencias</h3>
														</div>

														<div class="card-body">
															<div class="table-responsive hoverable-table overflow-hidden">
																<table id="tabla_listado_inc" class="table text-md-nowrap">
																	<thead>
																		<tr>
																			<th>Fecha</th>
																			<th class="">Descripcion</th>
																			<th></th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																		if ($contIncidencias != 0) { //Hay incidencias                                            
																			while ($fila2 = $datosInc->fetch_assoc()):
																				
																				

																				echo "
                                                            <tr>                                                            
                                                            <td class='text-left tx-bold'>" . date('d-m-Y',strtotime($fila2['fecha']) ) . "</td>                                                            
                                                            <td class='text-left small'>" . $fila2['descripcion'] . "</td>                                                            
                                                            <td class='text-center wp-20'><i style='cursor:pointer' class='fa fa-eye btn_ver_incidencia' cod_maqui=" . $codigo_maquina . " cod_inc=" . $fila2['cod_incidencia'] . "></i></td>";
																				echo "</tr>";

																			endwhile;
																		} 
																		?>
																	</tbody>
																</table>
															</div>
														</div>
													<!-- </div> -->
												</div>

											</div>
										</div>
									</div>
								</div>
							</div>

							<?php
						} //while($fila1 = $result->fetch_assoc()){
					} //if($result->num_rows == 0){// Usuario web no existente
					?>
				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

			<!-- Sidebar-right-->
			<?php
			//include("sidebar.php");
			?>
			<!--/Sidebar-right-->


		</div>
		</div><!-- modal-dialog -->
		</div>

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
		<script src="assets/plugins/jquery/jquery.min.js"></script>

		<!-- Internal Data tables -->
		<script src="./assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="./assets/plugins/datatable/datatables.min.js"></script>
		<script src="./assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
		<script src="./assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
		<script src="./assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
		<script src="./assets/plugins/datatable/js/jszip.min.js"></script>
		<script src="./assets/plugins/datatable/js/buttons.html5.min.js"></script>
		<script src="./assets/plugins/datatable/js/buttons.print.min.js"></script>
		<script src="./assets/plugins/datatable/js/buttons.colVis.min.js"></script>
		<script src="./assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
		<script src="./assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>

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

		<!-- custom js -->
		<script src="assets/js/custom.js"></script>
		<script src="assets/js/maquina.js"></script>
		<?php
}
?>

</body>

</html>