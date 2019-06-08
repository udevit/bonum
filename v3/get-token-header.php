<?php
	header('Content-Type: application/json; charset=UTF-8');
	
	//incluir librerias y clases
	include_once './config/database.php';
	include_once './objects/user.php';

	//librerias de jwt
	include_once 'libs/php-jwt-master/src/BeforeValidException.php';
	include_once 'libs/php-jwt-master/src/ExpiredException.php';
	include_once 'libs/php-jwt-master/src/JWT.php';
	include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
	use \Firebase\JWT\JWT;
	
	//incluir el archivo de claims / configuracion
	include_once './config/core.php';
	
	//inicializar los obetos de la BD
	$database = new Database();
	$db = $database->getConnection();
	
	//crear instancia de la clase user
	$user =  new User($db);
	
	//agregar regla en .htaccess 
	//RewriteRule .* - [e=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
	
	//obtener los datos del header
	//$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
	//$arr = explode(" ", $authHeader);
	
	$headers = apache_request_headers();
	$arr = explode(" ", $headers['Authorization']);
	
	//split 
	$splitStr = explode(":", base64_decode($arr[2]));
	
	//decodificar en base64
	$email = $splitStr[0];
	$psw = $splitStr[1];
	
	//asignar los valores a las propiedades de mi objeto user
	$user->email = $email;
	$email_exists = $user->emailExists();
	
	if($email_exists && password_verify($psw, $user->password)){
		$token = array(
			"iss"=>$issuer_claim,
			"aud"=>$audience_claim,
			"iat"=>$issuedat_claim,
			"nbf"=>$notbefore_claim,
			"exp"=>$expire_claim,
			"data"=>array(
				"id"=>$user->id,
				"name"=>$user->name,
				"lastname"=>$user->lastname,
				"email"=>$user->email
			)
		);
		
		http_response_code(200);
		
		//generar jwt
		$jwt = JWT::encode($token, $key);
		
		$response = array(
			"message"=>"Token generado exitosamente.",
			"expireAt"=>$expire_claim,
			"expireAtStr"=>date('m/d/Y h:i:s a', $expire_claim),
			"jwt"=>$jwt
		);
		
		echo json_encode($response);
	}else{
		http_response_code(401);
		
		$response = array(
			'status'=>401,
			'status_message'=>'Acceso denegado.'
		);
		echo json_encode($response);
	}
	
?>