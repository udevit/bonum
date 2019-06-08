<?php
	//incluir librerias
	include_once './config/database.php';
	include_once './objects/employee.php';
	
	//recupera el metodo http que invoca al archivo PHP
	$request_method = $_SERVER["REQUEST_METHOD"];
	
	switch($request_method)
	{
		case 'GET':   //recuperar datos del empleado
			if(!empty($_GET['id']))
			{
				//recuperar el empleado por ID
				$id = intval($_GET['id']);
				//echo 'ID: '.$id;
				get_employees_by_id($id);
			}
			else
			{
				//recuperar la lista de todos los empleados del sistema
				//echo 'recuperar la lista de todos los empleados del sistema';
				get_employees();
			}
			break;
		
		case 'POST':  //crear o agregar un nuevo empleado
			insert_employee();
			break;
			
		case 'PUT'; //actualizar la informacion de un empleado
			if(!empty($_GET['id']))
			{
				//recuperar el empleado por ID
				$id = intval($_GET['id']);
				
				//actualizando al empleado
				update_employee($id);
			}else{
				header("HTTP/1.0 405 Method Not Allowed");
			}
			break;
			
		case 'DELETE': //eliminar un empleado
			if(!empty($_GET['id']))
			{
				//recuperar el empleado por ID
				$id = intval($_GET['id']);
				
				//actualizando al empleado
				delete_employee($id);
			}else{
				header("HTTP/1.0 405 Method Not Allowed");
			}
			break;
			
		default:
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
	
	function get_employees_by_id($id){
		
	}
	
	function get_employees(){
		//inicializando objeto db y employee
		$database = new Database();
		$db = $database->getConnection();
		
		//inicializar el objeto employee
		$employee = new Employee($db);
		
		//ejecutar la consulta
		$stmt = $employee->read();
		
		$num = $stmt->rowCount();
		
		header('Content-Type: application/json');
		
		if($num > 0 ){
			//definimos el array de empleados
			$employees_arr = array();
			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$employees_arr[] = array(
					'employee_id'=> $id,
					'employee_name'=> $name,
					'employee_age'=> $age,
					'employee_salary'=> $salary
				);
			}
			echo json_encode($employees_arr);
		}else{
			generateErrorResponse(404, 'La lista esta vacia');
		}
	}
	
	
	function insert_employee(){
		header('Content-Type: application/json');
		
		$data = json_decode(file_get_contents('php://input'), true);
		
		if(!empty($data["employee_name"]) &&
		   !empty($data["employee_age"]) &&
		   !empty($data["employee_salary"])
		){
			//inicializar object BD
			$database = new Database();
			$db = $database->getConnection();
			
			//incializamos el objeto empleado
			$employee = new Employee($db);
			
			//establecer los valores de los atributos del objeto employee
			$employee->name = $data["employee_name"];
			$employee->age = $data["employee_age"];
			$employee->salary = $data["employee_salary"];
			
			//creando el empleado
			if($employee->create()){
				generateErrorResponse(201, 'El empleado fue creado exitosamente.');
			}else{
				generateErrorResponse(503, 'Servicio no disponible');
			}
		}else{
			generateErrorResponse(400, 'Solicitud incorrecta.');
		}
		
	}
	
	function update_employee($id){
		
	}
	
	function delete_employee($id){
		
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