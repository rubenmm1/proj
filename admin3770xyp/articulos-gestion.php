<?php
@session_start();
if (!isset($_SESSION['cod_usuario'])) {
	header("location: index.php");
}

include("../conexion.php");

if (!isset($_POST['cod_articulo'])) { // añadir nuevo articulo
	$cod_articulo_mod = 0;
	$nombre = "";
	$descripcion = "";
	$precio = "0";
	$foto = 0;
	$tipoMaq = 0;
	$breadcrumb = "Nuevo";

} else { // Modificamos el articulo
	$cod_articulo_mod = $_POST['cod_articulo'];

	$sql = "select * from articulos where cod_articulo=" . $cod_articulo_mod;
	$result = $conexion->query($sql);

	while ($fila1 = $result->fetch_assoc()) {
		$nombre = $fila1['nombre'];
		$descripcion = $fila1['descripcion'];
		$precio = $fila1['precio'];
		$tipoMaq = $fila1['tipo'];
		$foto = 1;
	}
	$breadcrumb = "Modificar";



}

?>
<!DOCTYPE html>
<html lang="es">
<!--- Internal Select2 css-->
<link href="../assets/plugins/select2/css/select2.min.css" rel="stylesheet">

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
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Artículos</h4><span
								class="text-muted mt-1 tx-13 ms-2 mb-0">/ <?php echo $breadcrumb; ?></span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->

				<div class="row  ">
					<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 mx-auto">
						<div class="card  box-shadow-0">
							<div class="card-header">
							</div>
							<div class="card-body pt-0">
								<form class="form-horizontal">
									<div class="form-group">
										<label class="form-label">Nombre</label>
										<input type="text" class="form-control" id="nombre" placeholder="nombre"
											value='<?php echo $nombre; ?>'>
									</div>
									<div class="form-group">
										<label class="form-label">Tipo</label>
										<select class="form-control select2-no-search" id=tipo>
											<option label="Elija un tipo">
											</option>
											<?php
											$sql = "select * from tipo_articulos order by descripcion";
											$resultT = $conexion->query($sql);
											while ($filaT = $resultT->fetch_assoc()) {
												
												if ($filaT['cod_tipo_articulo'] == $tipoMaq) {
													
													echo '<option selected value="' . $filaT['cod_tipo_articulo'] . '">' . $filaT['descripcion'] . '</option>';
												} else {
													echo '<option  value="' . $filaT['cod_tipo_articulo'] . '">' . $filaT['descripcion'] . '</option>';
												}
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<label class="form-label">Descripcion</label>
										<textarea class="form-control" placeholder="Descripcion" id="descripcion"
											rows="5"><?php echo $descripcion; ?></textarea>
									</div>

									<div class="form-group mb-0 mt-3 justify-content-end">
										<label class="form-label">Precio</label>
										<input type="number" class="form-control" id="precio" placeholder="precio"
											value=<?php echo $precio; ?>>

									</div>
									<div class="form-group mb-0 mt-3">
										<label class="form-label">Foto</label>

										<?php
										if ($foto) {
											$foto_ant = "../fotos/" . $cod_articulo_mod . "/" . $cod_articulo_mod . ".jpg";
										} else {
											$foto_ant = '../assets/img/default_image.jpg';

										}
										echo '<img class="card-img-top" src="' . $foto_ant . '">';
										echo '<input type="file" id=foto class="" data-height="200" data-max-file-size="3M" />';
										?>
									</div>
									<div class="form-group mb-0 mt-3 justify-content-end">
										<div>
											<input type="hidden" name="cod_articulo" id="cod_articulo"
												value='<?php echo $cod_articulo_mod; ?>' />
											<div id="btn-guardar" class="btn btn-primary">Guardar</div>
											<div id="btn-cancelar" class="btn btn-secondary">Cancelar</div>
											<div id='msn'>

											</div>
										</div>
									</div>
								</form>
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

	<!--Internal Fileuploads js-->
	<script src="../assets/plugins/fileuploads/js/fileupload.js"></script>
	<script src="../assets/plugins/fileuploads/js/file-upload.js"></script>

	<!--Internal Fancy uploader js-->
	<script src="../assets/plugins/fancyuploder/jquery.ui.widget.js"></script>
	<script src="../assets/plugins/fancyuploder/jquery.fileupload.js"></script>
	<script src="../assets/plugins/fancyuploder/jquery.iframe-transport.js"></script>
	<script src="../assets/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
	<script src="../assets/plugins/fancyuploder/fancy-uploader.js"></script>


	<!-- custom js -->
	<script src="../assets/js/custom.js"></script>

	<script>
		$("#btn-guardar").on("click", function () {
			nombre = $("#nombre").val();
			descripcion = $("#descripcion").val();
			tipo = $("#tipo").val();
			precio = $("#precio").val();
			foto = $("#foto").val();
			cod_articulo = $("#cod_articulo").val();// en el caso de que sea un nuevo articulo, el valor es 0

			$.ajax({
				url: 'articulos_jquery.php',
				type: 'post',
				data: "cod_articulo=" + cod_articulo + "&nombre=" + nombre + "&descripcion=" + descripcion + "&tipo=" + tipo + "&precio=" + precio + "&foto=" + foto,
				beforeSend: function () {
					$("#msn").html('<div class="text-center col-md-12 m-5"><div class="spinner-border avatar-lg text-primary m-2" role="status"></div></div>');
				},
				success: function (response) {
					//$("#msn").html(response);
					console.log(response);
					window.location.href = "articulos.php";
				}
			});
		})


		$("#btn-cancelar").click(function (e) { 
			e.preventDefault();
			window.history.back();
		});


		$("#foto").on('change', function () {
			var formData = new FormData();
			var files = $('#foto')[0].files[0];
			formData.append('file', files);
			$.ajax({
				url: 'upload.php',
				type: 'post',
				data: formData,
				contentType: false,
				processData: false,
				success: function (response) {
					if (response != 0) {

						// console.log(response);
						$(".card-img-top").attr("src", response);
					} else {
						alert('Formato de imagen incorrecto.');
					}
				}
			});
			return false;
		});


	</script>

</body>

</html>