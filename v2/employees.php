<?php
	// include database and object files
	include_once './config/database.php';
	include_once './objects/employee.php';

	//recupera el metodo http que invoca al archivo PHP
	$request_method = $_SERVER["REQUEST_METHOD"];

	//echo "Metodo HTTP: ".$request_method;
	
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
			$id=intval($_GET["id"]);
			update_employee($id);
			break;
		case 'DELETE': //eliminar un empleado
			$id=intval($_GET["id"]);
			delete_employee($id);
			break;
		default:
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
	
	function get_employees_by_id($id)
	{
		header('Content-Type: application/json');
		
		// instantiate database and employee object
		$database = new Database();
		$db = $database->getConnection();
	
		// initialize object
		$employee = new Employee($db);
		$employee->id = $id;
	
		// query employees
		$stmt = $employee->readOne();
		
		header('Content-Type: application/json');
		
		if($employee->name != null){
			// create array
			$employee_arr[] = array(
				"employee_id" => $employee->id,
				"employee_name" => $employee->name,
				"employee_age" => $employee->age,
				"employee_salary" => $employee->salary
			);
			
			echo json_encode($employee_arr);
		}else{
			// set response code - 404 Not found
			http_response_code(404);
		 
			// tell the user no employee found
			$response = array(
				'status'=>404,
				'status_mensaje'=>'Employee not found.'
			);
			
			echo json_encode($response);
		}
	}
	
	function get_employees()
	{
		// instantiate database and employee object
		$database = new Database();
		$db = $database->getConnection();
	
		// initialize object
		$employee = new Employee($db);
	
		// query employees
		$stmt = $employee->read();
		$num = $stmt->rowCount();
		
		header('Content-Type: application/json');
		
		// check if more than 0 record found
		if($num>0){
			// employees array
			$employees_arr = array();
			
			// retrieve our table contents
			// fetch() is faster than fetchAll()
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				// extract row
				// this will make $row['name'] to
				// just $name only
				extract($row);
		 
				$employees_arr[] = array(
					"employee_id" => $id,
					"employee_name" => $name,
					"employee_age" => $age,
					"employee_salary" => $salary
				);
			}
			
			echo json_encode($employees_arr);
		}else{
			// set response code - 404 Not found
			http_response_code(404);
		 
			// tell the user no employees is empty
			$response = array(
				'status'=>404,
				'status_mensaje'=>'The list of employees is empty.'
			);
			
			echo json_encode($response);
		}
	}
	
	function insert_employee()
	{
		header('Content-Type: application/json');
		
		$data = json_decode(file_get_contents('php://input'), true);
		
		// make sure data is not empty
		if(!empty($data["employee_name"]) &&
		   !empty($data["employee_salary"]) &&
		   !empty($data["employee_age"])
		){
			// instantiate database and employee object
			$database = new Database();
			$db = $database->getConnection();
		
			// initialize object
			$employee = new Employee($db);
			
			// set employee property values
			$employee->name=$data["employee_name"];
			$employee->salary=$data["employee_salary"];
			$employee->age=$data["employee_age"];
		
			// create the employee
			if($employee->create()){
		 
				// set response code - 201 created
				http_response_code(201);
		 
				// tell the user
				$response = array(
					'status'=>201,
					'status_mensaje'=>'Employee was created.'
				);
				
				echo json_encode($response);
			}
			// if unable to create the employee, tell the user
			else{
		 
				// set response code - 503 service unavailable
				http_response_code(503);
		 
				// tell the user
				$response = array(
					'status'=>503,
					'status_mensaje'=>'Unable to create employee.'
				);
				
				echo json_encode($response);
			}
	
		}else{
			// set response code - 400 bad request
			http_response_code(400);
		 
			// tell the user
			$response = array(
				'status'=>400,
				'status_mensaje'=>'Bad request, data is incomplete.'
			);
			
			echo json_encode($response);
		}
	}
	
	function update_employee($id)
	{
		header('Content-Type: application/json');
		
		$data = json_decode(file_get_contents('php://input'), true);
		
		// make sure data is not empty
		if($id != null &&
		   !empty($data["employee_name"]) &&
		   !empty($data["employee_salary"]) &&
		   !empty($data["employee_age"])
		){
			// instantiate database and employee object
			$database = new Database();
			$db = $database->getConnection();
		
			// initialize object
			$employee = new Employee($db);
			
			// set ID property of employee to be edited
			$employee->id = $id;

			// set employee property values
			$employee->name=$data["employee_name"];
			$employee->salary=$data["employee_salary"];
			$employee->age=$data["employee_age"];
			
			// update the employee
			if($employee->update()){
				// set response code - 200 ok
				http_response_code(200);
				
				// tell the user
				$response = array(
					'status'=>200,
					'status_mensaje'=>'Employee was updated.'
				);
				
				echo json_encode($response);
			}
			// if unable to update the employee, tell the user
			else{
				// set response code - 503 service unavailable
				http_response_code(503);
			 
				// tell the user
				$response = array(
					'status'=>503,
					'status_mensaje'=>'Unable to create employee.'
				);
				
				echo json_encode($response);
			}
		}else{
			// set response code - 400 bad request
			http_response_code(400);
		 
			// tell the user
			$response = array(
				'status'=>400,
				'status_mensaje'=>'Bad request, data is incomplete.'
			);
			
			echo json_encode($response);
		}
	}
	
	function delete_employee($id)
	{
		header('Content-Type: application/json');
		
		if($id != null){
			// instantiate database and employee object
			$database = new Database();
			$db = $database->getConnection();
		
			// initialize object
			$employee = new Employee($db);
			
			// set ID property of employee to be edited
			$employee->id = $id;
			
			// delete the employee
			if($employee->delete()){
				// set response code - 200 ok
				http_response_code(200);
				
				// tell the user
				$response = array(
					'status'=>200,
					'status_mensaje'=>'Employee was deleted.'
				);
				
				echo json_encode($response);
			}
			// if unable to delete the employee
			else{
				// set response code - 503 service unavailable
				http_response_code(503);
			 
				// tell the user
				$response = array(
					'status'=>503,
					'status_mensaje'=>'Unable to delete employee.'
				);
				
				echo json_encode($response);
			}
		}else{
			// set response code - 400 bad request
			http_response_code(400);
		 
			// tell the user
			$response = array(
				'status'=>400,
				'status_mensaje'=>'Please provide the user ID.'
			);
			
			echo json_encode($response);
		}
	}
	
?>