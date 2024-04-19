<?php

include("conexion.php");
include("functions.php");
require('fpdf/fpdf.php');

$cod_doc =$_POST['cod_factura_pdf'];

/////********************
/////********************

$consultaLineas = "select facturas_lineas.*  from facturas_lineas
left join articulos on articulos.cod_articulo = facturas_lineas.id_articulo
where id_factura = '".$cod_doc."' order by cod_linea";

$consulta="select c.*, f.fecha, s.descripcion as area  from facturas f
inner join clientes c on c.cod_cliente=f.id_cliente
inner join series s on s.cod_serie=f.id_serie
where cod_factura='".$cod_doc."'";
//echo $consulta;

$result = $conexion->query($consulta);

  while($fila1 = $result->fetch_assoc()){
    $_SESSION['fac_cod_documento'] = $cod_doc;
    $_SESSION['fac_razon_social'] = $fila1['razon_social'];
    $_SESSION['fac_nombre_empre'] = $fila1['nombre'];
    $_SESSION['fac_direccion'] = $fila1['direccion'];
    $_SESSION['fac_poblacion'] = $fila1['poblacion'];
    $_SESSION['fac_telefono'] = $fila1['telefono'];
    $_SESSION['fac_movil'] = $fila1['movil'];
    $_SESSION['fac_provincia'] = $fila1['provincia'];
    $_SESSION['fac_cp'] = $fila1['cp'];
    $_SESSION['fac_cif'] = $fila1['cif'];
    $_SESSION['fac_fecha']=formatearfecha($fila1['fecha']);
    $_SESSION['fac_area']=$fila1['area'];
    $email = $fila1['email'];

    $_SESSION['fac_agente'] = $fila1['agente'];
    $_SESSION['fac_ruta']= $fila1['formato_envio'];

  }

class PDF extends FPDF
{
  // Cabecera de página
  function Header()
  {
    $font='Arial';
    // Logo
    $this->Image('fpdf/cabecera.jpg',10,5,190);
    // Arial bold 15
    $this->SetFont($font,'B',20);
    // Movernos a la derecha
    $this->Cell(80);
    // Salto de línea
    $this->Ln(19);
    $this->Cell(0,10,utf8_decode('FACTURA'),0,0,'R');
    //$this->Cell(0,10,''.$this->PageNo().' de{nb}',0,0,'C');
    $this->Ln(55);


  //Rectangulo derecha
    $this->Rect(10,45,95,30);
    $this->SetXY(10,46);
    $this->SetFont($font,'B',11);
    $this->Cell(60,5,utf8_decode("FACTURA"),0,0,'L');
    $this->Cell(35,5,$_SESSION['fac_cod_documento'],0,0,'R');
    $this->Line(10,52,105,52);

    $this->SetXY(11,53);


    $this->SetFont($font,'B',9);
    $this->Cell(18,5,utf8_decode("CIF-NIF"),0,0,'L');

    $this->SetFont($font,'',9);
    $this->Cell(45,5,$_SESSION['fac_cif'],0,0,'L');

    $this->SetFont($font,'B',9);
    $this->Cell(12,5,utf8_decode("Fecha"),0,0,'L');

    $this->SetFont($font,'',9);
    $this->Cell(95,5,$_SESSION['fac_fecha'],0,0,'L');




    $this->SetXY(11,58);

    $this->SetFont($font,'B',9);
    $this->Cell(18,5,utf8_decode("Cliente"),0,0,'L');

    $this->SetFont($font,'',9);
    $this->Cell(95,5,utf8_decode($_SESSION['fac_nombre_empre']),0,0,'L');



    $this->SetXY(11,63);

    $this->SetFont($font,'B',9);
    $this->Cell(18,5,utf8_decode("Domicilio"),0,0,'L');

    $this->SetFont($font,'',9);
    $this->MultiCell(85,5,utf8_decode($_SESSION['fac_direccion']).", ".$_SESSION['fac_poblacion'].", ".$_SESSION['fac_provincia'].", ".$_SESSION['fac_cp'],0,'L',0);



    $this->SetXY(110,45);

    $this->SetFont($font,'B',14);
    $this->Cell(18,5,utf8_decode("AREA: ").utf8_decode($_SESSION['fac_area']),0,0,'L');

  //cabecera de las lineas

    $this->SetFont($font,'B',9);
    $this->SetXY(11,85);
    $this->Cell(10,5,'Cod.',0,0,'C');
    $this->Cell(115,5,utf8_decode('   Artículo'),0,0,'L');
    $this->Cell(20,5,'Precio Un.',0,0,'C');
    $this->Cell(20,5,'Cantidad',0,0,'C');
    $this->Cell(10,5,'Desc',0,0,'C');
    $this->Cell(15,5,'Subtotal',0,0,'C');


    //$this->Ln(20);
//
    }
  // Pie de página
    function Footer()
    {
      // Posición: a 1,5 cm del final
      $this->SetY(-17);
      // Arial italic 8
      $this->SetFont('Arial','B',9);
      // Número de página
      $this->Cell(0,8,utf8_decode('Nº DE CUENTA DEL BANCO BBVA, PARA PAGOS CON INGRESOS O TRANSFERENCIAS: ES20 0182 5897 4502 0157 4318'),0,0,'C');
      $this->SetY(-12);
      $this->SetFont('Arial','',5);
      $this->Cell(0,8,utf8_decode('D3 IDI & INDUSTRIES S.L. Inscrita en el registro mercantil de Huelva, Tomo 1153, Folio 91, Hoja H-26187, Inscripción 1ª, Cif B-02649176'),0,0,'C');

    }

}
// Creación del objeto de la clase heredada

define('EURO'," ".chr(128));

$pdf = new PDF();
$posXIniciallineas=95;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('helvetica','',9);
$pdf->SetXY(96,$posXIniciallineas);
$UltimosRegistrosMax=9;
$UltimosRegistros=1;

$sql = "SELECT * FROM facturas_lineas fl
INNER JOIN articulos a ON a.cod_articulo=fl.id_articulo
WHERE id_factura='".$cod_doc."'";
//echo $sql;
$resultLineas = $conexion->query($sql);
$i=1;


while($filaLineas = $resultLineas->fetch_assoc()){
  $UltimosRegistros++;
  $posY=$pdf->GetY();
  if ($posY>270){
    $pdf->AddPage('P');
    $posY=$posXIniciallineas;
    $pdf->SetY($posY);
    $UltimosRegistros=1;
  };
  $pdf->SetX(7);
  if($filaLineas['id_articulo']==0){
    $cod_articulo="";
  }else{
    $cod_articulo=$filaLineas['id_articulo'];
  }
  $pdf->Cell(15,4,$cod_articulo,0,0,'C');
  $pdf->MultiCell(100,3,utf8_decode($filaLineas['nombre']),0,'');
  $pdf->SetY($posY);
  $pdf->SetX(145);

  $pdf->Cell(10,4,$filaLineas['precio_unitario'],0,0,'R');
  $pdf->Cell(15,4,$filaLineas['cantidad'],0,0,'R');
  $pdf->Cell(13,4,$filaLineas['desc_linea'],0,0,'R');
  $pdf->Cell(18,4,$filaLineas['subtotal'],0,0,'R');


  $pdf->Ln(6);
  //$pdf->Cell(30,5,'UNIDAD',0,0,'C');
}
if($UltimosRegistros>$UltimosRegistrosMax){
  $pdf->AddPage();
}
//*TOTAL

  $pdf->ln('5');

  $pdf->SetY(230);
  $pdf->Line(5,225,200,225);
  $sqlFactura="select * from facturas f
  where cod_factura = '".$cod_doc."'";
  //echo $sqlFactura;
  $resulFac=$conexion->query($sqlFactura);

  while ($filaFac=$resulFac->fetch_assoc()){
    $valor_tarifa= $filaFac['tarifa'];
    $tiempos_pago_valor= $filaFac['tiempos_pago_valor'];
    $tiempos_pago_texto= $filaFac['tiempos_pago_texto'];
    $re=$filaFac['re'];
    $iva=$filaFac['iva'];
    $importe_descuento=$filaFac['importe_descuento'];

  }

//*Linea 1
  $pdf->SetFont('helvetica','B',8);
  $pdf->Cell(27,6,'Tiempo de pagos:',0,0,'R');
  $pdf->SetFont('helvetica','',8);
  $pdf->Cell(50,6,$tiempos_pago_texto,0,0,'L');
//  $pdf->Cell(27,6,number_format($kg_adr,2).' Kg',0,0,'R');

  $pdf->SetX(150);
  $pdf->SetFont('helvetica','',11);
  $pdf->Cell(30,6,'Dto.Tarifa:',0,0,'R');

  $pdf->SetFont('helvetica','',11);
  $pdf->Cell(23,6,$valor_tarifa." %",0,0,'R');


  $pdf->ln('6');
  $pdf->SetX(150);
  $pdf->SetFont('helvetica','',11);
  $pdf->Cell(30,6,'Tiempos de pago:',0,0,'R');

  $pdf->SetFont('helvetica','',11);
  $pdf->Cell(23,6,$tiempos_pago_valor." %",0,0,'R');



  $pdf->ln('6');
  $pdf->SetX(150);
  $pdf->SetFont('helvetica','B',11);
  $pdf->Cell(30,6,'Sub-Total:',0,0,'R');

  $pdf->SetFont('helvetica','B',11);
  $pdf->Cell(23,6,$importe_descuento.EURO,0,0,'R');


  $pdf->ln('6');
  $pdf->SetX(150);
  $pdf->SetFont('helvetica','',11);
  $pdf->Cell(30,6,'IVA('.$iva.'%):',0,0,'R');

  $iva_valor=number_format($importe_descuento*$iva/100,2,".","");

  $pdf->SetFont('helvetica','',11);
  $pdf->Cell(23,6,$iva_valor.EURO,0,0,'R');

  $pdf->ln('6');
  $pdf->SetX(150);
  $pdf->SetFont('helvetica','',11);
  $pdf->Cell(30,6,'R.E.('.$re.'%):',0,0,'R');


  $re_valor= number_format($importe_descuento*$re/100,2,".","");

  $pdf->SetFont('helvetica','',11);
  $pdf->Cell(23,6,$re_valor.EURO,0,0,'R');


  ///*Lineas
  $pdf->ln('6');
  $pos_y=$pdf->GetY();



  $pdf->ln('6');

  $pdf->SetX(150);
  $pdf->SetFont('helvetica','B',15);
  $pdf->Cell(15,6,'TOTAL: ',0,0,'R');
  $total=$importe_descuento+$re_valor+$iva_valor;
  $pdf->SetFont('helvetica','B',15);
  $pdf->Cell(38,6,$total.EURO,0,0,'R');

  //$pdf->Output('F',"pdfs/".$cod_doc.".pdf");

  $pdf->Output('D',$cod_doc.".pdf");
 ?>
