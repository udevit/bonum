<?php
	header('Content-Type: application/json; charset=UTF-8');
	
	//librerias de jwt
	include_once 'libs/php-jwt-master/src/BeforeValidException.php';
	include_once 'libs/php-jwt-master/src/ExpiredException.php';
	include_once 'libs/php-jwt-master/src/JWT.php';
	include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
	use \Firebase\JWT\JWT;
	
	//incluir el archivo de claims / configuracion
	include_once './config/core.php';
	
	//obtener los datos del request
	$headers = apache_request_headers();
	
	$arr = explode(" ", $headers['Authorization']);
	
	$jwt = isset($arr[2])?$arr[2]:"";

	if($jwt){
		try{
			//decodificar el token
			$decoded = JWT::decode($jwt, $key, array('HS256'));
			
			http_response_code(200);
			
			$response = array(
				"message"=>'Acceso otorgado, token valido.',
				"data"=>$decoded->data
			);
			echo json_encode($response);
		}catch(Exception $e){
			$msg = 'Acceso denegado, ' . $e->getMessage();
			generateHttpMessage(401, $msg);
		}
	}else{
		generateHttpMessage(401, 'Acceso denegado.');
	}
	
	function generateHttpMessage($code, $message){
		http_response_code($code);
		$response = array(
			"status"=>$code,
			"status_message"=>$message
		);
		echo json_encode($response);
	}
	
?>