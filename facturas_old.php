<?php
@session_start();
if (!isset($_SESSION['cod_cliente']))
{
	header("location: index.php");
}

include ("conexion.php");
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

					<div class="row row-sm">

						<div class="col-xl-8">
							<div class="card">
								<div class="card-header pb-0">
								</div>
								<div class="card-body">
									<div class="table-responsive hoverable-table">
										<table id="example-delete" class="table text-md-nowrap">
											<thead>
												<tr>
													<th>NºFactura</th>
													<th>Fecha</th>
													<th>Importe</th>
													<th>Estado</th>
													<th></th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql="select * from facturas
					              where id_cliente =".$_SESSION['cod_cliente'];
												$result = $conexion->query($sql);
												if($result->num_rows == 0){// Usuario web no existente
													echo "no hay facturas";
												}else{// existe el usuario web
													while($fila1 = $result->fetch_assoc()){
														if($fila1['pagado']==1){
															$pagado="<span class='badge bg-success'>Pagado</span>";
														}else{
															$pagado="<span class='badge bg-danger'>Pendiente</span>";
														}
														echo "
														<tr>
															<td class='tx-bold'>".$fila1['cod_factura']."</td>
															<td class='text-center'>".$fila1['fecha']."</td>
															<td class='text-right tx-bold'>".$fila1['importe']." €</td>
															<td class='text-center'>".$pagado."</td>
															<td class='text-center'><i class='far fa-file-pdf'></i></td>
															<td class='text-center'><i class='fa fa-search-plus'></i></i></td>
														</tr>
														";
													}
												}
												?>

											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="card mg-b-20">
								<div class="card-body">
									<div class="ps-0">
										<div class="main-profile-overview">
											<div class="d-flex justify-content-between mg-b-20">
												<div>
													<h5 class="main-profile-name"><?php echo $fila1['nombre_maquina'];?></h5>
													<small>SN:<strong><?php echo $fila1['nserie'];?></strong></small>
													<p class="main-profile-name-text"><?php echo $fila1['descripcion_maquina'];?></p>
												</div>
											</div>
											<?php
											echo '<img alt="" src="fotos/'.$fila1['id_articulo'].'/'.$fila1['id_articulo'].'.jpg"><a class="img-fluid" href="JavaScript:void(0);"></a>'
											?>
											<h6>Articulo</h6>
											<div class="main-profile-bio">
												<h6><?php echo $fila1['nombre'];?></h6>
												<?php echo $fila1['descripcion'];?>
											</div><!-- main-profile-bio -->
											<div class="row">
												<div class="col-md-4 col mb20">
													<h5>947</h5>
													<h6 class="text-small text-muted mb-0">Followers</h6>
												</div>
												<div class="col-md-4 col mb20">
													<h5>583</h5>
													<h6 class="text-small text-muted mb-0">Tweets</h6>
												</div>
												<div class="col-md-4 col mb20">
													<h5>48</h5>
													<h6 class="text-small text-muted mb-0">Posts</h6>
												</div>
											</div>
											<hr class="mg-y-30">
											<label class="main-content-label tx-13 mg-b-20">Social</label>
											<div class="main-profile-social-list">
												<div class="media">
													<div class="media-icon bg-primary-transparent text-primary">
														<i class="icon ion-logo-github"></i>
													</div>
													<div class="media-body">
														<span>Github</span> <a href="">github.com/spruko</a>
													</div>
												</div>
												<div class="media">
													<div class="media-icon bg-success-transparent text-success">
														<i class="icon ion-logo-twitter"></i>
													</div>
													<div class="media-body">
														<span>Twitter</span> <a href="">twitter.com/spruko.me</a>
													</div>
												</div>
												<div class="media">
													<div class="media-icon bg-info-transparent text-info">
														<i class="icon ion-logo-linkedin"></i>
													</div>
													<div class="media-body">
														<span>Linkedin</span> <a href="">linkedin.com/in/spruko</a>
													</div>
												</div>
												<div class="media">
													<div class="media-icon bg-danger-transparent text-danger">
														<i class="icon ion-md-link"></i>
													</div>
													<div class="media-body">
														<span>My Portfolio</span> <a href="">spruko.com/</a>
													</div>
												</div>
											</div>
											<hr class="mg-y-30">
											<h6>Skills</h6>
											<div class="skill-bar mb-4 clearfix mt-3">
												<span>HTML5 / CSS3</span>
												<div class="progress mt-2">
													<div class="progress-bar bg-primary-gradient" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%"></div>
												</div>
											</div>
											<!--skill bar-->
											<div class="skill-bar mb-4 clearfix">
												<span>Javascript</span>
												<div class="progress mt-2">
													<div class="progress-bar bg-danger-gradient" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 89%"></div>
												</div>
											</div>
											<!--skill bar-->
											<div class="skill-bar mb-4 clearfix">
												<span>Bootstrap</span>
												<div class="progress mt-2">
													<div class="progress-bar bg-success-gradient" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 80%"></div>
												</div>
											</div>
											<!--skill bar-->
											<div class="skill-bar clearfix">
												<span>Coffee</span>
												<div class="progress mt-2">
													<div class="progress-bar bg-info-gradient" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 95%"></div>
												</div>
											</div>
											<!--skill bar-->
										</div><!-- main-profile-overview -->
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

			<!-- Message Modal -->
			<div class="modal fade" id="chatmodel" tabindex="-1" role="dialog"  aria-hidden="true">
				<div class="modal-dialog modal-dialog-right chatbox" role="document">
					<div class="modal-content chat border-0">
						<div class="card overflow-hidden mb-0 border-0">
							<!-- action-header -->
							<div class="action-header clearfix">
								<div class="float-start hidden-xs d-flex ms-2">
									<div class="img_cont me-3">
										<img src="assets/img/faces/6.jpg" class="rounded-circle user_img" alt="img">
									</div>
									<div class="align-items-center mt-2">
										<h4 class="text-white mb-0 fw-semibold">Daneil Scott</h4>
										<span class="dot-label bg-success"></span><span class="me-3 text-white">online</span>
									</div>
								</div>
								<ul class="ah-actions actions align-items-center">
									<li class="call-icon">
										<a href="" class="d-done d-md-block phone-button" data-bs-toggle="modal" data-bs-target="#audiomodal">
											<i class="si si-phone"></i>
										</a>
									</li>
									<li class="video-icon">
										<a href="" class="d-done d-md-block phone-button" data-bs-toggle="modal" data-bs-target="#videomodal">
											<i class="si si-camrecorder"></i>
										</a>
									</li>
									<li class="dropdown">
										<a href="" data-bs-toggle="dropdown" aria-expanded="true">
											<i class="si si-options-vertical"></i>
										</a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><i class="fa fa-user-circle"></i> View profile</li>
											<li><i class="fa fa-users"></i>Add friends</li>
											<li><i class="fa fa-plus"></i> Add to group</li>
											<li><i class="fa fa-ban"></i> Block</li>
										</ul>
									</li>
									<li>
										<a href=""  class="" data-bs-dismiss="modal" aria-label="Close">
											<span aria-hidden="true"><i class="si si-close text-white"></i></span>
										</a>
									</li>
								</ul>
							</div>
							<!-- action-header end -->

							<!-- msg_card_body -->
							<div class="card-body msg_card_body">
								<div class="chat-box-single-line">
									<abbr class="timestamp">February 1st, 2019</abbr>
								</div>
								<div class="d-flex justify-content-start">
									<div class="img_cont_msg">
										<img src="assets/img/faces/6.jpg" class="rounded-circle user_img_msg" alt="img">
									</div>
									<div class="msg_cotainer">
										Hi, how are you Jenna Side?
										<span class="msg_time">8:40 AM, Today</span>
									</div>
								</div>
								<div class="d-flex justify-content-end ">
									<div class="msg_cotainer_send">
										Hi Connor Paige i am good tnx how about you?
										<span class="msg_time_send">8:55 AM, Today</span>
									</div>
									<div class="img_cont_msg">
										<img src="assets/img/faces/9.jpg" class="rounded-circle user_img_msg" alt="img">
									</div>
								</div>
								<div class="d-flex justify-content-start ">
									<div class="img_cont_msg">
										<img src="assets/img/faces/6.jpg" class="rounded-circle user_img_msg" alt="img">
									</div>
									<div class="msg_cotainer">
										I am good too, thank you for your chat template
										<span class="msg_time">9:00 AM, Today</span>
									</div>
								</div>
								<div class="d-flex justify-content-end ">
									<div class="msg_cotainer_send">
										You welcome Connor Paige
										<span class="msg_time_send">9:05 AM, Today</span>
									</div>
									<div class="img_cont_msg">
										<img src="assets/img/faces/9.jpg" class="rounded-circle user_img_msg" alt="img">
									</div>
								</div>
								<div class="d-flex justify-content-start ">
									<div class="img_cont_msg">
										<img src="assets/img/faces/6.jpg" class="rounded-circle user_img_msg" alt="img">
									</div>
									<div class="msg_cotainer">
										Yo, Can you update Views?
										<span class="msg_time">9:07 AM, Today</span>
									</div>
								</div>
								<div class="d-flex justify-content-end mb-4">
									<div class="msg_cotainer_send">
										But I must explain to you how all this mistaken  born and I will give
										<span class="msg_time_send">9:10 AM, Today</span>
									</div>
									<div class="img_cont_msg">
										<img src="assets/img/faces/9.jpg" class="rounded-circle user_img_msg" alt="img">
									</div>
								</div>
								<div class="d-flex justify-content-start ">
									<div class="img_cont_msg">
										<img src="assets/img/faces/6.jpg" class="rounded-circle user_img_msg" alt="img">
									</div>
									<div class="msg_cotainer">
										Yo, Can you update Views?
										<span class="msg_time">9:07 AM, Today</span>
									</div>
								</div>
								<div class="d-flex justify-content-end mb-4">
									<div class="msg_cotainer_send">
										But I must explain to you how all this mistaken  born and I will give
										<span class="msg_time_send">9:10 AM, Today</span>
									</div>
									<div class="img_cont_msg">
										<img src="assets/img/faces/9.jpg" class="rounded-circle user_img_msg" alt="img">
									</div>
								</div>
								<div class="d-flex justify-content-start ">
									<div class="img_cont_msg">
										<img src="assets/img/faces/6.jpg" class="rounded-circle user_img_msg" alt="img">
									</div>
									<div class="msg_cotainer">
										Yo, Can you update Views?
										<span class="msg_time">9:07 AM, Today</span>
									</div>
								</div>
								<div class="d-flex justify-content-end mb-4">
									<div class="msg_cotainer_send">
										But I must explain to you how all this mistaken  born and I will give
										<span class="msg_time_send">9:10 AM, Today</span>
									</div>
									<div class="img_cont_msg">
										<img src="assets/img/faces/9.jpg" class="rounded-circle user_img_msg" alt="img">
									</div>
								</div>
								<div class="d-flex justify-content-start">
									<div class="img_cont_msg">
										<img src="assets/img/faces/6.jpg" class="rounded-circle user_img_msg" alt="img">
									</div>
									<div class="msg_cotainer">
										Okay Bye, text you later..
										<span class="msg_time">9:12 AM, Today</span>
									</div>
								</div>
							</div>
							<!-- msg_card_body end -->
							<!-- card-footer -->
							<div class="card-footer">
								<div class="msb-reply d-flex">
									<div class="input-group">
										<input type="text" class="form-control " placeholder="Typing....">
										<div class="input-group-text ">
											<button type="button" class="btn btn-primary ">
												<i class="far fa-paper-plane" aria-hidden="true"></i>
											</button>
										</div>
									</div>
								</div>
							</div><!-- card-footer end -->
						</div>
					</div>
				</div>
			</div>

			<!--Video Modal -->
			<div id="videomodal" class="modal fade">
				<div class="modal-dialog" role="document">
					<div class="modal-content bg-dark border-0 text-white">
						<div class="modal-body mx-auto text-center p-7">
							<h5>Valex Video call</h5>
							<img src="assets/img/faces/6.jpg" class="rounded-circle user-img-circle h-8 w-8 mt-4 mb-3" alt="img">
							<h4 class="mb-1 fw-semibold">Daneil Scott</h4>
							<h6>Calling...</h6>
							<div class="mt-5">
								<div class="row">
									<div class="col-4">
										<a class="icon icon-shape rounded-circle mb-0 me-3" href="#">
											<i class="fas fa-video-slash"></i>
										</a>
									</div>
									<div class="col-4">
										<a class="icon icon-shape rounded-circle text-white mb-0 me-3" href="#" data-bs-dismiss="modal" aria-label="Close">
											<i class="fas fa-phone bg-danger text-white"></i>
										</a>
									</div>
									<div class="col-4">
										<a class="icon icon-shape rounded-circle mb-0 me-3" href="#">
											<i class="fas fa-microphone-slash"></i>
										</a>
									</div>
								</div>
							</div>
						</div><!-- modal-body -->
					</div>
				</div><!-- modal-dialog -->
			</div><!-- modal -->

			<!-- Audio Modal -->
			<div id="audiomodal" class="modal fade">
				<div class="modal-dialog" role="document">
					<div class="modal-content border-0">
						<div class="modal-body mx-auto text-center p-7">
							<h5>Valex Voice call</h5>
							<img src="assets/img/faces/6.jpg" class="rounded-circle user-img-circle h-8 w-8 mt-4 mb-3" alt="img">
							<h4 class="mb-1  fw-semibold">Daneil Scott</h4>
							<h6>Calling...</h6>
							<div class="mt-5">
								<div class="row">
									<div class="col-4">
										<a class="icon icon-shape rounded-circle mb-0 me-3" href="#">
											<i class="fas fa-volume-up bg-light text-dark"></i>
										</a>
									</div>
									<div class="col-4">
										<a class="icon icon-shape rounded-circle text-white mb-0 me-3" href="#" data-bs-dismiss="modal" aria-label="Close">
											<i class="fas fa-phone text-white bg-success"></i>
										</a>
									</div>
									<div class="col-4">
										<a class="icon icon-shape  rounded-circle mb-0 me-3" href="#">
											<i class="fas fa-microphone-slash bg-light text-dark"></i>
										</a>
									</div>
								</div>
							</div>
						</div><!-- modal-body -->
					</div>
				</div><!-- modal-dialog -->
			</div><!-- modal -->

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


		<!-- custom js -->
		<script src="assets/js/custom.js"></script>

	</body>
</html>
