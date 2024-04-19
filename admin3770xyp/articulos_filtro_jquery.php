<?php
@session_start();
if (!isset($_SESSION['cod_usuario']))
{
	header("location: index.php");
}

include ("../conexion.php");
include ("../functions.php");

//data: "cod_articulo="+cod_articulo+"&nombre="+nombre+"&descripcion="+descripcion+"&tipo="+tipo+"&activo="+activo+"&precio="+precio+"&imagen="+imagen,
if(isset($_POST['busqueda'])){
		$var_busqueda = htmlspecialchars($_POST['busqueda'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
}else{
	$var_busqueda="";
}

if($var_busqueda<>""){
	$filtro=" AND (nombre LIKE '%".$var_busqueda."%' OR a.descripcion LIKE '%".$var_busqueda."%')";
}else{
	$filtro="";
}
$sql="select a.*, ta.descripcion AS descrip_tipo, ta.color as color from articulos a
inner join tipo_articulos ta on a.tipo = ta.cod_tipo_articulo
where activo=1 ".$filtro;
//echo $sql;
$result = $conexion->query($sql);
if($result->num_rows == 0){// Usuario web no existente
	echo '<div class="col-12">
	<center>
	<h4> No hay artículos</h4>
	</center>
	</div>';
}else{// existe el usuario web
	while($fila1 = $result->fetch_assoc()){

		$tipo="<div class='badge ".$fila1['color']."'>".$fila1['descrip_tipo']."</div>";
		$foto = '../fotos/'.$fila1['cod_articulo'].'/'.$fila1['cod_articulo'].'.jpg';

		if(!file_exists($foto)){
			$foto = "../fotos/default.png";
		}

		echo '
		<div class="col-md-6 col-lg-4 col-xl-3 col-sm-12">
			<div class="card">
				<div class="card-body h-100">
					<div class="pro-img-box">
						<div class="d-flex product-sale">
							'.$tipo.'
						</div>
						<img class="w-100" src="'.$foto.'"
							alt="product-image">
						<div class="adtocart" nombre="'.$fila1['nombre'].'" descripcion="'.$fila1['descripcion'].'" precio="'.$fila1['precio'].'" cod_articulo = "'.$fila1['cod_articulo'].'" > <i class="las la-shopping-cart "></i></div>
					</div>

					<div class="text-center pt-4">
						<input type=number min="1" max="999" maxlength="1" value=1 id="cant_'.$fila1['cod_articulo'].'" /> <br /><small>cant.</small>
						<h3 class="h6 mb-2 mt-4 fw-bold text-uppercase">'.$fila1['nombre'].'</h3>
						<h4 class="h5 mb-0 mt-2 text-center fw-bold text-danger">'.$fila1['precio'].' €

						</h4>

					</div>
				</div>
			</div>
		</div>
		';
	}
}
?>
