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

<!--- Internal Sweet-Alert css-->
<link href="../assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">

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
							<div class="d-flex"><h4 class="content-title mb-0 my-auto">Albaranes</h4></div>
						</div>
					</div>
					<!-- breadcrumb -->

					<div class="row row-sm">

						<div class="col-xl-12">
							<div class="card">
								<div class="card-header pb-0 text-right">
									<div class="btn btn-success" id='btn_facturar'>Pasar a factura</div>
								</div>
								<div class="card-body">
									<div class="table-responsive hoverable-table">
										<table id="tabla_listado" class="table text-md-nowrap">
											<thead>
												<tr>
													<th class='text-center'>Albaranes</th>
													<th>Cliente</th>
													<th data-orderable="false">Observaciones</th>
													<th class='text-center' >Fecha</th>
													<th class='text-right'>Importe</th>
													<th class='text-center'  >Fac.</th>
													<th  data-orderable="false"></th>

												</tr>
											</thead>
											<tbody>
												<?php
												$sql="select * from albaranes a
												inner join clientes c on c.cod_cliente= a.id_cliente
												order by fecha asc";
												$result = $conexion->query($sql);
												if($result->num_rows == 0){// Usuario web no existente
													echo "No hay clientes";
												}else{// existe el usuario web
													while($fila1 = $result->fetch_assoc()){
														if($fila1['factura']<>""){
															$albaraneado=
															$facturar="<span class='btn_abrir_factura puntero' cod='".$fila1['factura']."'>".$fila1['factura']."</span>";
															$borrar_facturado="<i class='fa fa-trash tx-gray-400'></i>";
															$icono_mod="eye";
														}else{
															//$facturar="<div class='badge bg-danger btn_pasar_factura' cod='".$fila1['cod_albaran']."'>Pasar a factura</div>";
															$facturar='<input type="checkbox" id=a_facturar2 name="a_facturar" class="puntero" value="'.$fila1['cod_albaran'].'####'.$fila1['id_cliente'].'####'.$fila1['tiempos_pago_valor'].'####'.$fila1['cod_serie'].'">';
															$borrar_facturado="<i class='fa fa-trash btn_eliminar text-danger puntero' cod=".$fila1['cod_albaran']." ></i>";
															$icono_mod="edit";
														}
													echo "
													<tr id='reg_".$fila1['cod_albaran']."'>
														<td class=' text-center tx-bold wd-5p'>".$fila1['cod_albaran']."</td>
														<td class='tx-bold wd-20p'>".$fila1['razon_social']." <small>(".$fila1['cif'].")</small></td>
														<td class='small'>".$fila1['observaciones']."</td>
														<td class='text-center wd-10p'>".formatearfecha($fila1['fecha'])."</td>
														<td class='text-right tx-bold wd-5p'>".$fila1['importe_descuento']." €</td>
														<td class='text-center wd-10p'>".$facturar."</td>
														<td class='text-right  wd-5p'><i class='fa fa-".$icono_mod." btn_modificar puntero' cod=".$fila1['cod_albaran']."></i>&nbsp;
														".$borrar_facturado."</td>

													</tr>";
													}
												}
												?>

											</tbody>
										</table>

										<form method="post" name='form_modificar' id="form_modificar" action="albaranes-gestion.php" >
											<input type=hidden name='cod_albaran' id='cod_albaran' />
										</form>

										<form method="post" name='form_modificar_factura' id="form_modificar_factura" action="facturas-gestion.php" >
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


		<!--<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>-->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


		<!-- custom js -->
		<script src="../assets/js/custom.js"></script>
		<script>

		$('#tabla_listado').DataTable({
			responsive: true,
			dom: 'Bfrtip',
			buttons:[
				'pdf'
			],
			 order: [[ 0, "desc" ]],
			 language: {
             "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
         }
		});

		$(".btn_abrir_factura").on("click",function(){
			codigo = $(this).attr("cod");
			$("#cod_factura").val(codigo);
			$("#form_modificar_factura").submit();
		})


		$(".btn_modificar").on("click",function(){
			codigo = $(this).attr("cod");
			$("#cod_albaran").val(codigo);
			$("#form_modificar").submit();
		})

		$(".btn_eliminar").on("click",function(){
			codigo = $(this).attr("cod");
			if(confirm("Se va a eliminar el albarán. Confirmar?")){
				$.ajax({
					url: 'albaran_eliminar_jquery.php',
					type: 'post',
					data: "cod_albaran="+codigo,
					beforeSend: function() {
					},
					success: function(response) {
						$("#reg_"+codigo).css("display","none");
					}
				});

			}
		});


		$(document).on( 'click', '#btn_facturar', function(){
			codigos_albaranes_sel="";
			i=0;
			mismaEmpresa=true;
			mismaT_pago=true;
			mismaT_serie=true;
			$("input[name='a_facturar']:checked").each(function (i) {
					valor=$(this).val();
					arrayValor=valor.split('####');
					if(i==0){
						codigos_albaranes_sel=arrayValor[0];
						empresa=arrayValor[1];
						t_pago=arrayValor[2];
						t_serie=arrayValor[3];
					}else{
						if(empresa!=arrayValor[1]){
							mismaEmpresa=false;
						}
						if(t_pago!=arrayValor[2]){
							mismaT_pago=false;
						}
						if(t_pago!=arrayValor[3]){
							mismaT_serie=false;
						}
						codigos_albaranes_sel=codigos_albaranes_sel+"','"+arrayValor[0];
					}
					i++;
      });

			if(codigos_albaranes_sel==""){
				alert("Debes seleccionar un albarán")
			}else{
				if(!mismaEmpresa){
					alert("No se pueden facturar albaranes de distintos clientes")
				}else{

					if(!mismaT_pago){
						alert("Los albaranes tienen distintos tiempos de pago")
					}else{
						if(!mismaT_serie){
							alert("Los albaranes tienen distintas series")
						}else{
							$.ajax({
								url: 'albaran_a_factura.php',
								type: 'post',
								data: "cod_albaran="+codigos_albaranes_sel,
								beforeSend: function() {
								},
								success: function(response) {
									swal.fire("Factura "+response+" creada!", "Se ha facturado.", "success");
									window.location.href = "albaranes.php";
								}
							});//ajax
						}//if(mismaT_serie)

					}//if(mismaT_pago)
				}

			}

		});

		</script>
	</body>
</html>
