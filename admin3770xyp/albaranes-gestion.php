<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

if(isset($_POST['cod_albaran'])){
	$albaranmodificar=true;
	$cod_albaran = $_POST['cod_albaran'];
	$sql="select * from albaranes
	where cod_albaran='".$cod_albaran."'";

	$resultP = $conexion->query($sql);
	while($filaP = $resultP->fetch_assoc()){
			$id_cliente=$filaP['id_cliente'];
			$fecha_albaran=formatearfecha($filaP['fecha']);
			$N_factura=$filaP['factura'];
			$observaciones = $filaP['observaciones'];

			$t_pagos_valor = $filaP['tiempos_pago_valor'];
			$t_pagos_texto = $filaP['tiempos_pago_texto'];

			$tarifa = $filaP['tarifa'];


			if($N_factura<>""){
				$facturado=true;
			}else{
				$facturado=false;
			}
			$titulo = $cod_albaran;
	}


}else{
	$albaranmodificar=false;
	$titulo = "Nuevo";
	$cod_albaran = 0;
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
							<div class="d-flex"><h4 class="content-title mb-0 my-auto">Albaranes</h4><span class="text-muted mt-1 tx-13 ms-2 mb-0">/ <?php echo $titulo;?></span></div>
						</div>
					</div>
					<!-- breadcrumb -->

					<div class="row row-sm">
						<div class="col-md-12 col-xl-12">
							<div class=" main-content-body-invoice">
								<div class="card card-invoice">
									<div class="card-body">
										<div class="invoice-header">
											<h1 class="invoice-title">ALBARAN</h1>
											<a href="#" class="btn btn-success float-end m-2"  onclick="javascript:window.history.back();">
												<i class="fa fa-reply"></i> Volver
											</a>

										</div><!-- invoice-header -->
										<div class="row">
											<div class="col-6" <?php if($facturado){echo "style='display:none;'";}?>>
												<label>Cliente</label>
												<select class="js-example-basic-single js-states form-control" name="combo_cliente" id="combo_cliente">
													<option ></option>
													<?php
													$sqlC="select * from clientes where activo=1 order by nombre asc";
													$resultC = $conexion->query($sqlC);
													while($filaC = $resultC->fetch_assoc()){
														if($filaC['cod_cliente']==$id_cliente){
															echo "<option selected value='".$filaC['cod_cliente']."'>".$filaC['razon_social']."</option>";
														}else{
															echo "<option value='".$filaC['cod_cliente']."'>".$filaC['razon_social']."</option>";
														}

													}
													?>
												</select>
											</div>
											<div class="col-6" <?php if($facturado){echo "style='display:none;'";}?>>

											</div>

										</div>
										<div class="row mg-t-20">
											<div class="col-md-8">
												<label class="tx-gray-600">Albarán a</label>
												<div class="billed-to">
													<h6 id="p_a_razon_social"></h6>
													<p id="p_a_direccion"><p>
													<p id="p_a_telefono"></p>
													<p id="p_a_email"></p>

												</div>
											</div>
											<?php
											if($albaranmodificar){
											 echo'
												<div class="col-md">
													<label class="tx-gray-600">Información del albarán</label>
													<p class="invoice-info-row"><span>Nº Albarán</span> <span><strong>'.$cod_albaran.'</strong></span></p>
													<p class="invoice-info-row"><span>Fecha</span> <span>'.$fecha_albaran.'</span></p>
													<p class="invoice-info-row"><span>Factura:</span> <span>'.$N_factura.'</span></p>
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
														<?php
														if(!$facturado){
														?>
														<th class="wd-5p"></th>
														<th class="wd-5p"></th>
														<?php
														}
														?>
													</tr>
												</thead>
												<tbody id='lineas_albaran'>
											 </tbody>
											 <tbody>
													<tr>
														<td class="valign-middle" colspan="3" rowspan="7">
															<label>Tiempos de pago</label>
															<select class="form-control" name="combo_t_pago" id="combo_t_pago" style="width: 240px;">
																<option ></option>
																<?php
																$sqlT="select * from tiempos_pago order by descripcion asc";
																$resultT = $conexion->query($sqlT);
																while($filaT = $resultT->fetch_assoc()){
																	if($filaT['valor']>0){
																		$signo="+";
																	}else{
																		$signo="";
																	}
																	if($filaT['valor']==$t_pagos_valor && $filaT['descripcion']==$t_pagos_texto){
																		echo "<option selected desc='".$filaT['descripcion']."' value='".$filaT['valor']."'>".$filaT['descripcion']." (".$signo.$filaT['valor']."%)</option>";
																	}else{
																		echo "<option desc='".$filaT['descripcion']."' value='".$filaT['valor']."'>".$filaT['descripcion']." (".$signo.$filaT['valor']."%)</option>";
																	}

																}
																?>
															</select>
														</td>
														
														<tr>
															<td class="tx-right">Dto.Tarifa</td>
															<td class="tx-right" colspan="2" ><span id='tarifa_cliente'><?php echo $tarifa;?></span> %</td>
														</tr>
														<tr>
															<td class="tx-right">Tiempos de pago</td>
															<?php
															if($t_pagos_valor>0){
																$signo="+";
															}else{
																$signo="";
															}
															?>
															<td class="tx-right" colspan="2" ><span id='t_pago'><?php echo $signo.$t_pagos_valor;?></span> %</td>
														</tr>
														</td>
														<td class="tx-right h5">Subtotal</td>
														<td class="tx-right h5" colspan="2" id='txt_subotal_albaran'>0.00 €</td>
													</tr>
													<tr>
														<td class="tx-right">IVA (<span id='iva_cliente'></span>%)</td>
														<td class="tx-right" colspan="2"  id='txt_iva_albaran'>0.00 €</td>
													</tr>
													<tr>
														<td class="tx-right">R.E. (<span id='re_cliente'></span>%)</td>
														<td class="tx-right" colspan="2"  id='txt_re_albaran'>0.00 €</td>
													</tr>
													<tr>
														<td class="tx-right tx-uppercase tx-bold tx-inverse">Total</td>
														<td class="tx-right" colspan="2">
															<h4 class="tx-primary tx-bold" id='txt_total_albaran'>0.00 €</h4>
														</td>
													</tr>
												</tbody>
											</table>
											<h6 class='pt-3'>Observaciones</h6>
											<textarea id=observaciones name=observaciones rows=4 style='width:100%;border:none;background-color:#edecec;font-size:13px;padding:10px;'><?php echo $observaciones;?></textarea>
										</div>
										<hr class="mg-b-40">
										<input type='hidden' id='cod_albaran' value='<?php echo $cod_albaran;?>'/>
										<!--
										<a class="btn btn-purple float-end mt-3 ms-2" href="">
											<i class="mdi mdi-currency-usd me-1"></i>Pay Now
										</a>
									-->
										<a href="#" class="btn btn-danger float-end mt-3 ms-2"  onclick="javascript:window.print();">
											<i class="mdi mdi-printer me-1"></i>Imprimir
										</a>


										<?php
										if(!$facturado){
											echo '<bottom class="btn btn-success float-end mt-3 ms-2" id="btn_guardar">
												<i class="fa fa-save"></i> Guardar
											</bottom>';
										}

										if($albaranmodificar && !$facturado){
												echo '
												<bottom class="btn btn-info float-end mt-3 ms-2 " id="btn_pasar_a_factura" cod="'.$cod_albaran.'">
													<i class="far fa-file-alt me-1"></i> Facturar
												</bottom>
												';
										}
										 ?>
									</div>
								</div>
							</div>
						</div><!-- COL-END -->
					</div>

					<?php
					if(!$facturado){ // En el caso que se haya albaraneado, no se muestra la busqueda de articulos
					?>
					<div class="row row-sm">

						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body p-2">
									<div class="input-group">

											<div class='col-md-6'>
												<label>Categoria</label>
												<select class="js-example-basic-single js-states form-control" name="combo_cliente" id="combo_categoria">
													<option ></option>
													<?php
													$sqlC="select * from categorias where activo=1 order by nombre_categoria asc";
													$resultC = $conexion->query($sqlC);
													while($filaC = $resultC->fetch_assoc()){
														echo "<option value='".$filaC['cod_categoria']."'>
														".$filaC['nombre_categoria']."</option>";
													}
													?>
												</select>
											</div>
											<div class='col-md-6'>
												<label>Nombre/descripcion</label>
												<div class="input-group">
													<input type="text" id="txt_buscar" class="form-control" placeholder="Busquda ...">
													<span class="input-group-text p-0">
														<button class="btn btn-primary" id="btn_buscar" type="button">Buscar</button>
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
					<?php
					}
					?>
				</div>
				<!--  -->
				<div style='display:none;' id='btn_mostrar_modal' class="btn ripple btn-primary" data-bs-effect="effect-scale" data-bs-target="#modaldemo1" data-bs-toggle="modal" href=""></div>
				<!-- Container closed -->
				<!-- Basic modal -->
				<div class="modal fade effect-scale" id="modaldemo1">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content modal-content-demo">
							<div class="modal-header">
								<h6 class="modal-title">Modificar</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
							</div>

							<div class="modal-body">
								<div class=row>
										<div class="col-12 pt-2">
											<h6 id="modal_nombre"></h6>
											<label>Descripcion</label>
											<textarea id='modal_descripcion' rows=5  style='width:100%;'></textarea>
										</div>
										<div class="col-3 pt-2 text-center">
											<label>Precio U.</label><br />
											<!--<p id='modal_precio_u'> </p>-->
											<input style='width:80px;' type=number id="modal_precio_u_txt"  min=0/>
										</div>
										<div class="col-3 pt-2 text-center">
											<label>Cantidad</label><br />
											<input style='width:45px;' type=number id="modal_cantidad" maxlength="1" max=999 min=1/>
										</div>
										<div class="col-3 pt-2 text-center">
											<label>Dto. %</label><br />
											<input style='width:45px;' type=number id="modal_dto" maxlength="1" max=999 min=0 value="0"/>
										</div>
										<div class="col-3 pt-2 text-center">
											<label>Subtotal</label><br />
											<h4 id='modal_subtotal'> </h4>
										</div>
								</div>
							</div>

							<div class="modal-footer">
								<input type=hidden id=modal_cod_articulo />
								<button class="btn ripple btn-primary" id='modal_btn_guardar' type="button">Guardar</button>
								<button class="btn ripple btn-secondary" id='modal_btn_cerrar' data-bs-dismiss="modal" type="button">Cerrar</button>
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


			include("footer.php");
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


		<!--<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>-->
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

		$(document).on( 'click', '.btn_modificar', function(){

			cod_articulo = $(this).attr("cod");
			precio_uni = $(this).attr("precio_uni");

			$('#modal_cod_articulo').val(cod_articulo);

			$('#modal_nombre').html( $('#txt_nombre_'+cod_articulo).html())
			$('#modal_descripcion').val( $('#txt_descripcion_'+cod_articulo).html())
			$('#modal_cantidad').val($('#txt_cantidad_cod_ant_'+cod_articulo).html())
			$('#modal_dto').val($('#txt_dto_'+cod_articulo).html())

			subtotal=$('#txt_subtotal_'+cod_articulo).html().slice(0,-2)
			$('#modal_subtotal').html(subtotal)

			precio_uni=$('#txt_precio_uni_'+cod_articulo).html().slice(0,-2)



			$('#modal_precio_u').html( precio_uni)
			$('#modal_precio_u_txt').val( precio_uni)

			$('#modal_cantidad').attr('cod',cod_articulo);
			$('#modal_cantidad').attr('precio_uni',precio_uni);


			$("#btn_mostrar_modal").trigger("click");

			/*
				$("#txt_cantidad_cod_"+codigo).css("display","block");
				$("#txt_cantidad_cod_"+codigo).focus();
				$("#txt_cantidad_cod_ant_"+codigo).css("display","none");
			*/

		})

		$("#modal_btn_guardar").on("click",function(){
			codigo=	$('#modal_cod_articulo').val();
			descripcion = $('#modal_descripcion').val()


			$("#txt_descripcion_"+codigo).html(descripcion)
			$("#txt_cantidad_cod_ant_"+codigo).html($('#modal_cantidad').val())

			$("#txt_dto_"+codigo).html($('#modal_dto').val())

			$("#txt_subtotal_"+codigo).html($('#modal_subtotal').html()+" €")

			$("#txt_precio_uni_"+codigo).html($('#modal_precio_u_txt').val()+" €")

			arrayArticulos[codigo][0]=$('#modal_cantidad').val();//cantidad
			arrayArticulos[codigo][1]=$('#modal_precio_u_txt').val();//Precio Unitario
			arrayArticulos[codigo][2]=descripcion;//descripcion
			arrayArticulos[codigo][3]=$('#modal_dto').val();//descripcion
			console.log(arrayArticulos);
			SumarTotal();


			$("#modal_btn_cerrar").trigger("click");


		})


		$(document).on( 'change', '#modal_cantidad,#modal_dto,#modal_precio_u_txt', function(){
			//precio_uni = $("#modal_precio_u").html();
			precio_uni = $("#modal_precio_u_txt").val();
			valor=$("#modal_cantidad").val();
			dto=$("#modal_dto").val();
			total=precio_uni*valor;
			total= total - (total*dto/100);
			total=total.toFixed(2)

			$('#modal_subtotal').html(total)
		})



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
					<?php
					if($facturado){
					?>
					$("#lineas_albaran").append('<tr id="linea_presu_'+cod_articulo+'" ><td id="txt_nombre_'+cod_articulo+'">'+nombre+'</td><td id="txt_descripcion_'+cod_articulo+'"></td><td class="tx-center"><div id="txt_cantidad_cod_ant_'+cod_articulo+'">'+cantidad+'</div><input style="display:none;" cod="'+cod_articulo+'" id="txt_cantidad_cod_'+cod_articulo+'" type=number maxlength="1" min="1" max="999" value='+cantidad+' precio_uni="'+precio_uni+'" class="txt_cantidad_modificar"/></td><td class="tx-right" id="txt_precio_uni_'+cod_articulo+'">'+precio_uni+' €</td><td class="tx-center" id="txt_dto_'+cod_articulo+'">0</td><td class="tx-right" id="txt_subtotal_'+cod_articulo+'">'+subtotal+' €</td></tr>')
					<?php
					}else{
					?>
					$("#lineas_albaran").append('<tr id="linea_presu_'+cod_articulo+'" ><td id="txt_nombre_'+cod_articulo+'">'+nombre+'</td><td id="txt_descripcion_'+cod_articulo+'"></td><td class="tx-center"><div id="txt_cantidad_cod_ant_'+cod_articulo+'">'+cantidad+'</div><input style="display:none;" cod="'+cod_articulo+'" id="txt_cantidad_cod_'+cod_articulo+'" type=number maxlength="1" min="1" max="999" value='+cantidad+' precio_uni="'+precio_uni+'" class="txt_cantidad_modificar"/></td><td class="tx-right" id="txt_precio_uni_'+cod_articulo+'">'+precio_uni+' €</td><td class="tx-center" id="txt_dto_'+cod_articulo+'">0</td><td class="tx-right" id="txt_subtotal_'+cod_articulo+'">'+subtotal+' €</td><td class="tx-center"><i class="fa fa-edit btn_modificar" cod="'+cod_articulo+'"></i></td><td class="tx-center"><i class="far fa-trash-alt btn_eliminar_linea" cod='+cod_articulo+'></i></td></tr>')
					<?php
					}
					?>
					$("#back-to-top").trigger("click");
					msn();
					$arrayArt=new Array(2);
					$arrayArt[0]=cantidad;//cantidad
					$arrayArt[1]=precio_uni;//precio_unitario
					$arrayArt[2]='';//descripcion
					$arrayArt[3]=0;//descuento

					//arrayArticulos.push($arrayArt);
					arrayArticulos[cod_articulo]=$arrayArt;

					//console.log(arrayArticulos);
					SumarTotal();
				}

			}

		})


		$(document).on( 'click', '.btn_eliminar_linea', function(){
			codigo = $(this).attr("cod")
			if(confirm("Deseas eliminar la linea?")){
				$("#linea_presu_"+codigo).remove();
				arrayArticulos[codigo]=[0,0,"",0];
				SumarTotal();
			}

		})

		function SumarTotal(){
			sumatorio=0;

			arrayArticulos.forEach( function(valor, indice, array) {

				subtotalinea=parseFloat(valor[0]*valor[1]);
				dto=parseFloat(valor[3]);
				subtotalinea=subtotalinea-(subtotalinea*dto/100);
				sumatorio=sumatorio + subtotalinea;
				//sumatorio=sumatorio + parseFloat(valor[0]*valor[1]);
			});

			dto_tarifa=$("#tarifa_cliente").html();
			t_pago=$("#t_pago").html();
			descuentos=t_pago-dto_tarifa;

			sumatorio=sumatorio+(sumatorio*descuentos/100);

			tipo_iva= $("#iva_cliente").html();
			$("#txt_subotal_albaran").html(sumatorio.toFixed(2)+" €");
			iva=sumatorio*tipo_iva/100;
			$("#txt_iva_albaran").html(iva.toFixed(2)+" €");

			tipo_re= $("#re_cliente").html();
			re=sumatorio*tipo_re/100;
			$("#txt_re_albaran").html(re.toFixed(2)+" €");

			total = sumatorio + iva + re;
			$("#txt_total_albaran").html(total.toFixed(2)+" €");

		}

		$("#combo_cliente").on("change",function(){
			codigo= $(this).val();

			$.ajax({
				url: 'datos_cliente_jquery.php',
				type: 'post',
				data: "codigo="+codigo,
				success: function(response) {
					arraydatos=response.split("####")
					$("#p_a_razon_social").html(arraydatos[0]);
					$("#p_a_direccion").html(arraydatos[1]);
					$("#p_a_telefono").html(arraydatos[2]);
					$("#p_a_email").html(arraydatos[3]);
					$("#iva_cliente").html(arraydatos[4]);
					$("#tarifa_cliente").html(arraydatos[5]);
					$("#re_cliente").html(arraydatos[6]);
					SumarTotal()
				}
			});

		})

	$("#btn_guardar").on("click",function(){
		cod_cliente=$("#combo_cliente").val();
		iva_cliente=$("#iva_cliente").html();
		observaciones=$("#observaciones").val();
		cod_albaran=$("#cod_albaran").val();
		dto_tarifa=$("#tarifa_cliente").html();

		t_pago_texto= $("[name='combo_t_pago'] option:selected").attr('desc');
		t_pago_valor=$("#combo_t_pago").val();

		if (cod_cliente==""){
			alert("Debes seleccionar un cliente");
		}else{
			hayArticulos=false;
			arrayArticulos.forEach( function(valor, indice, array) {
					if(valor[0]!=0){
						hayArticulos=true;
					}
			});

			if (!hayArticulos){
				alert("no hay articulos seleccionados")
			}else{

				var valParam = JSON.stringify(arrayArticulos);

				//alert (valParam);
				$.ajax({
					url: 'add_albaran.php',
					type: 'post',
					data: "codigo_cliente="+cod_cliente+"&dto_tarifa="+dto_tarifa+"&cod_albaran="+cod_albaran+"&t_pago_texto="+t_pago_texto+"&t_pago_valor="+t_pago_valor+"&iva_cliente="+iva_cliente+"&observaciones="+observaciones+"&array_articulos="+valParam,
					beforeSend: function() {
					},
					success: function(response) {
						arrayArticulos.length = 0;

						respuesta=response.split("#####");
						swal.fire(
							{
								title: 'Albarán '+respuesta[0]+' '+respuesta[1]+'!',
								text: 'Continuar!',
								type: 'success',
								confirmButtonColor: '#57a94f'
							}).then((result) => {
						    window.location.href = "albaranes.php";
						})
					}
				})//ajax
			}
		}
	})

	$("#btn_pasar_a_factura").on("click",function(){
		codigo=$(this).attr('cod');

		swal.fire({
			title: "Facturar",
			text: "Se va a facturar, deseas hacerlo?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Pasar",
			cancelButtonText: "No",
			closeOnConfirm: false,
			closeOnCancel: false,

		//inputPlaceholder: 'Seleccionar un tiempo de pago',
		showCancelButton: true
		/*
		inputValidator: (value) => {
			return new Promise((resolve) => {
				if (value === '') {
					resolve('Debes seleccionar un tiempo de pago')
				} else {

					$.ajax({
						url: 'presupuesto_a_albaran.php',
						type: 'post',
						data: "cod_presupuesto="+codigo+"&cod_tiempo_pago="+value,
						beforeSend: function() {
						},
						success: function(response) {
								swal.fire("Albaraneado!", "Se ha pasado a albarán.", "success");
								window.location.href = "albaranes.php";
						}
					})//ajax
					//resolve()
				}
			})
		}
		*/
	} ).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					//swal.fire("Duplicado!", "Se ha duplicado el presupuesto.", "success");
								$.ajax({
									url: 'albaran_a_factura.php',
									type: 'post',
									data: "cod_albaran="+codigo,
									beforeSend: function() {
									},
									success: function(response) {
											swal.fire(" Factura "+response+" creada!", "Se ha facturado.", "success");
											window.location.href = "facturas.php";
									}
								})//ajax

					/*
					$("#cod_presupuesto").val('0');
					$("#observaciones").val("Duplicado del presupuesto: "+presu+"\n"+obs )
					$("#btn_guardar").trigger("click");
					*/
				}
				});
	})


/*
	$("#btn_pasar_a_factura").on("click",function(){
		codigo=$(this).attr('cod');

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
		function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: 'albaran_a_factura.php',
					type: 'post',
					data: "cod_albaran="+codigo,
					beforeSend: function() {
					},
					success: function(response) {
							swal(" Factura "+response+" creada!", "Se ha facturado.", "success");
							//window.location.href = "facturas.php";
					}
				})//ajax
			} else {
			swal("Cancelado", "Se ha cancelado", "error");
			}
		});
	})

*/

	<?php
	/*************************/
	/* MODIFICAR albaran */
	/*************************/

	if($albaranmodificar){
		$cod_albaran = $_POST['cod_albaran'];

		$sql="select p.descripcion as descripcionLinea, p.*, a.*  from albaranes_lineas p
inner join articulos a on p.id_articulo=a.cod_articulo
where p.id_albaran='".$cod_albaran."'";

		$result = $conexion->query($sql);
		while($fila = $result->fetch_assoc()){
				$descripcionLinea =str_replace(array("\r\n", "\n", "\r"), '\r', $fila['descripcionLinea']);
			?>

			<?php
			if($facturado){
			?>
			$("#lineas_albaran").append('<tr id="linea_presu_<?php echo $fila['cod_articulo'];?>" ><td id="txt_nombre_<?php echo $fila['cod_articulo'];?>"><?php echo $fila['nombre'];?></td><td id="txt_descripcion_<?php echo $fila['cod_articulo'];?>"><?php echo $descripcionLinea;?></td><td class="tx-center"><div id="txt_cantidad_cod_ant_<?php echo $fila['cod_articulo'];?>"><?php echo $fila['cantidad'];?></div><input style="display:none;" cod="<?php echo $fila['cod_articulo'];?>" id="txt_cantidad_cod_<?php echo $fila['cod_articulo'];?>" type=number maxlength="1" min="1" max="999" value=<?php echo $fila['cantidad'];?> precio_uni="<?php echo $fila['precio_unitario'];?>" class="txt_cantidad_modificar"/></td><td class="tx-right" id="txt_precio_uni_<?php echo $fila['cod_articulo'];?>"><?php echo $fila['precio_unitario'];?> €</td>      <td class="tx-center" id="txt_dto_<?php echo $fila['cod_articulo'];?>"><?php echo $fila['desc_linea'];?></td>        <td class="tx-right" id="txt_subtotal_<?php echo $fila['cod_articulo'];?>"><?php echo $fila['subtotal'];?> €</td></tr>')
			<?php
			}else{
			?>
			$("#lineas_albaran").append('<tr id="linea_presu_<?php echo $fila['cod_articulo'];?>" ><td id="txt_nombre_<?php echo $fila['cod_articulo'];?>"><?php echo $fila['nombre'];?></td><td id="txt_descripcion_<?php echo $fila['cod_articulo'];?>"><?php echo $descripcionLinea;?></td><td class="tx-center"><div id="txt_cantidad_cod_ant_<?php echo $fila['cod_articulo'];?>"><?php echo $fila['cantidad'];?></div><input style="display:none;" cod="<?php echo $fila['cod_articulo'];?>" id="txt_cantidad_cod_<?php echo $fila['cod_articulo'];?>" type=number maxlength="1" min="1" max="999" value=<?php echo $fila['cantidad'];?> precio_uni="<?php echo $fila['precio_unitario'];?>" class="txt_cantidad_modificar"/></td><td class="tx-right" id="txt_precio_uni_<?php echo $fila['cod_articulo'];?>"><?php echo $fila['precio_unitario'];?> €</td>      <td class="tx-center" id="txt_dto_<?php echo $fila['cod_articulo'];?>"><?php echo $fila['desc_linea'];?></td>        <td class="tx-right" id="txt_subtotal_<?php echo $fila['cod_articulo'];?>"><?php echo $fila['subtotal'];?> €</td><td class="tx-center"><i class="fa fa-edit btn_modificar" cod="<?php echo $fila['cod_articulo'];?>"></i></td><td class="tx-center"><i class="far fa-trash-alt btn_eliminar_linea" cod=<?php echo $fila['cod_articulo'];?>></i></td></tr>')
			<?php
			}
			?>

				$arrayArt=new Array(2);
				$arrayArt[0]='<?php echo $fila['cantidad'];?>';//cantidad
				$arrayArt[1]='<?php echo $fila['precio_unitario'];?>';//precio_unitario
				$arrayArt[2]='<?php echo $descripcionLinea;?>';//descripcion
				$arrayArt[3]='<?php echo $fila['desc_linea'];?>';//descuento linea

				//arrayArticulos.push($arrayArt);
				arrayArticulos[<?php echo $fila['cod_articulo'];?>]=$arrayArt;

			<?php
		}
		?>
		$("#combo_cliente").trigger("change");
		SumarTotal()

		<?php
	}
	 ?>
	 $("#combo_t_pago").on("change",function(){
		 valor=$(this).val();
		 if (valor>0){
			 signo='+';
		 }else{
			 signo='';
		 }
		 $("#t_pago").html(signo+valor);
		 SumarTotal()
	 })
		</script>
	</body>
</html>
