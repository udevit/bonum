<?php
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	// generar json web token
	include_once 'config/core.php';
	include_once 'libs/php-jwt-master/src/BeforeValidException.php';
	include_once 'libs/php-jwt-master/src/ExpiredException.php';
	include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
	include_once 'libs/php-jwt-master/src/JWT.php';
	use \Firebase\JWT\JWT;
	
	// obtener datos enviados
	$data = json_decode(file_get_contents("php://input"));
	 
	// obtener jwt
	$jwt=isset($data->jwt) ? $data->jwt : "";
	
	// si el jwt no esta vacio
	if($jwt){
		// si es posible decodificar se muestra la informacion de usuario
		try {
			// decodificar jwt
			$decoded = JWT::decode($jwt, $key, array('HS256'));
	 
			// asignar respuesta HTTP
			http_response_code(200);
	 
			// mostrar detalles del usuario
			echo json_encode(array(
				"message" => "Acceso otorgado, token valido.",
				"data" => $decoded->data
			));
		}catch (Exception $e){
			$msg = 'Acceso denegado, ' . $e->getMessage();
			generateErrorResponse(401, $msg);
		}
	}else{
		generateErrorResponse(401, 'Acceso denegado.');
	}
	
	function generateErrorResponse($httpCode, $msg){
		http_response_code($httpCode);
		$response = array(
			'status'=>$httpCode,
			'status_message'=>$msg
		);
		echo json_encode($response);
	}
	
?>