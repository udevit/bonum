<?php
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	//incluir librerias
	include_once './config/database.php';
	include_once './objects/user.php';
	
	// generar json web token
	include_once 'config/core.php';
	include_once 'libs/php-jwt-master/src/BeforeValidException.php';
	include_once 'libs/php-jwt-master/src/ExpiredException.php';
	include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
	include_once 'libs/php-jwt-master/src/JWT.php';
	use \Firebase\JWT\JWT;

	//inicializando objeto db y employee
	$database = new Database();
	$db = $database->getConnection();
	
	//crear la instancia de la clase User
	$user = new User($db);
	
	// obtener el
	$data = json_decode(file_get_contents("php://input"));
	 
	// asignar la propiedad email del objeto
	$user->email = $data->email;
	$email_exists = $user->emailExists();
	
	// validar si el correo existe y la contrasena es correcta
	if($email_exists && password_verify($data->password, $user->password)){
		$token = array(
		   "iss" => $issuer_claim,
		   "aud" => $audience_claim,
		   "iat" => $issuedat_claim,
		   "nbf" => $notbefore_claim,
		   "exp" => $expire_claim,
		   "data" => array(
			   "id" => $user->id,
			   "name" => $user->name,
			   "lastname" => $user->lastname,
			   "email" => $user->email
		   )
		);
	 
		// asignar codigo de respuesta
		http_response_code(200);
	 
		// generar jwt
		$jwt = JWT::encode($token, $key);
		echo json_encode(
				array(
					"message" => "Token generado exitosamente.",
					"expireAt" => $expire_claim,
					"expireAtStr" => date('m/d/Y h:i:s a', $expire_claim),
					"jwt" => $jwt
				)
			);
	}else{
		generateErrorResponse(401, 'Acceso denegado');
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