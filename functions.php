<?php

////****************************************************************////
////****************************************************************////
///                  Funcion generica de envio de email            /////
////****************************************************************////
////****************************************************************////

function enviar_email($mensaje, $destinatarios, $Asunto)
{

	require("mail/class.phpmailer.php");
	require("mail/class.smtp.php");

	// Datos de la cuenta de correo utilizada para enviar vía SMTP
	$smtpHost = "mail.hiprosol.com";  // Dominio alternativo brindado en el email de alta
	$smtpUsuario = "hiprosol@hiprosol.com";  // Mi cuenta de correo
	$smtpClave = "IQmTbXrF2";  // Mi contraseña


	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Port = 587;
	$mail->IsHTML(true);
	$mail->CharSet = "utf-8";

	// VALORES A MODIFICAR //
	$mail->Host = $smtpHost;
	$mail->Username = $smtpUsuario;
	$mail->Password = $smtpClave;


	$mail->From = $smtpUsuario; // Email desde donde envío el correo.
	$mail->FromName = "Hiprosol";


	for ($i = 0; $i < count($destinatarios); $i++) {
		$mail->AddAddress($destinatarios[$i]); // Esta es la dirección a donde enviamos los datos del formulario
	}

	$mail->Subject = $Asunto; // Este es el titulo del email.
	//$mensajeHtml = nl2br($mensaje);
	$mail->Body = $mensaje; // Texto del email en formato HTML
	//$mail->AltBody = "{$mensaje} \n\n "; // Texto sin formato HTML
	// FIN - VALORES A MODIFICAR //

	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);

	$estadoEnvio = $mail->Send();
	if (!$estadoEnvio) {
		echo "Ocurrió un error inesperado.";
	}
}


///*** Funcion para obtener el contador correspondiente a la tabla ****/
function obtener_Cod($tabla)
{
	include("../conexion.php");
	/*obtener la id maxima del contador*/
	$sql = "update contadores set contador = contador + 1 where descripcion = '" . $tabla . "'";
	$conexion->query($sql);

	$sql = "select contador from contadores where descripcion='" . $tabla . "'";
	$resultCod = $conexion->query($sql);

	while ($filaCod = $resultCod->fetch_array()) {
		$cod = $filaCod['contador'];
	}
	/* FIN obtener la id maxima del contador*/

	return $cod;
}

function current_cod($tabla)
{
	include("../conexion.php");
	$sql = "select contador from contadores where descripcion='" . $tabla . "'";
	$resultCod = $conexion->query($sql);
	while ($filaCod = $resultCod->fetch_array()) {
		$cod = $filaCod['contador'];
	}
	return $cod;
}

///*** Funcion para obtener el contador correspondiente a la tabla ****/
function obtener_series($cod_serie, $documento)
{
	include("../conexion.php");

	/*Comprobar si se ha cambiado de año para inicializar los contadores */

	$sql = "Select * from series where cod_serie=" . $cod_serie;
	$resul = $conexion->query($sql);

	while ($fi = $resul->fetch_assoc()) {
		$anio = $fi['anio'];
	}

	$anioActual = date('Y');

	if ($anio <> $anioActual) {
		$sql = "update series set p = 0,a=0,f=0,ab=0,anio=" . $anioActual;
		$conexion->query($sql);
	}

	/*obtener la id maxima del contador*/
	$sql = "update series set " . $documento . " = " . $documento . " + 1 where cod_serie= " . $cod_serie;
	$conexion->query($sql);

	$sql = "select " . $documento . " as contador, codigo from series where cod_serie=" . $cod_serie;
	$resultCod = $conexion->query($sql);

	while ($filaCod = $resultCod->fetch_array()) {
		$cod = $filaCod['contador'];
		$prefijo = $filaCod['codigo'];
	}

	$anio = date('y');
	$digitos = "";
	for ($i = 0; $i < 4 - strlen($cod); $i++) {
		$digitos = $digitos . "0";
	}

	$codigo_presupuesto = $documento . $prefijo . $anio . "-" . $digitos . $cod;

	return $codigo_presupuesto;
}


///*********** Insertar logs de control $SQL **********////
function insertarlogs($sql, $identificador, $fichero)
{
	$txtlogs = fopen("logs/" . $fichero . ".txt", "a");
	fputs($txtlogs, $identificador . " [" . date("F j, Y, g:i a") . "] " . $sql . "\n");
	fclose($txtlogs);
}


function formatearfecha($fechaVar, $hora = false)
{
	if ($hora) {
		$arrayDato = explode(" ", $fechaVar);
		$hora = $arrayDato[1];
		$arrayfecha = explode("-", $arrayDato[1]);
		$fecha = $arrayfecha[2] . "-" . $arrayfecha[1] . "-" . $arrayfecha[0];
	} else {
		$arrayfecha = explode("-", $fechaVar);
		$fecha = $arrayfecha[2] . "-" . $arrayfecha[1] . "-" . $arrayfecha[0];
	}
	return $fecha;
}


function hexToRgb($hex, $alpha = false)
{
	$hex      = str_replace('#', '', $hex);
	$length   = strlen($hex);
	$rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
	$rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
	$rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
	if ($alpha) {
		$rgb['a'] = $alpha;
	}
	return $rgb;
}
