<?php
	$request_method=$_SERVER["REQUEST_METHOD"];
	
	switch($request_method)
	{
		case 'GET':
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				get_employees_by_id($id);
			}
			else
			{
				get_employees();
			}
			break;
		case 'POST':
			insert_employee();
			break;
		case 'PUT':
			$id=intval($_GET["id"]);
			update_employee($id);
			break;
		case 'DELETE':
			$id=intval($_GET["id"]);
			delete_employee($id);
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}

	function load_employees()
	{
		$response = array();
		
		$response[] = array(
			'id'=>1,
			'employee_name'=>'Gary',
			'employee_salary'=>100,
			'employee_age'=>30
		);
		
		$response[] = array(
			'id'=>2,
			'employee_name'=>'Pepe',
			'employee_salary'=>800,
			'employee_age'=>19
		);
		
		$response[] = array(
			'id'=>3,
			'employee_name'=>'Marco',
			'employee_salary'=>200,
			'employee_age'=>38
		);
		
		$response[] = array(
			'id'=>4,
			'employee_name'=>'Juan',
			'employee_salary'=>700,
			'employee_age'=>60
		);
		
		return $response;
	}
	
	function get_employees()
	{
		$response = load_employees();
		
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function get_employees_by_id($id=0)
	{
		$response = load_employees();
		
		header('Content-Type: application/json');
		
		$found = false;
		//buscando el empleado
		foreach($response as $empl)
			if($empl['id'] == $id)
			{	
				echo json_encode($empl); //empleado encontrado
				$found = true;
			}
		
		if(!$found)
		{
			http_response_code(404);

			$response=array(
				'status' => 0,
				'status_message' =>'Employee not found.'
			);
			
			echo json_encode($response);
		}
	}
	
	function insert_employee()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$employee_name=$data["employee_name"];
		$employee_salary=$data["employee_salary"];
		$employee_age=$data["employee_age"];
		
		$response=array(
			'status' => 1,
			'status_message' =>'Employee Added Successfully.'
		);
		
		header('Content-Type: application/json');
		http_response_code(201);
		
		echo json_encode($response);
	}
	
	function update_employee($id)
	{
		global $connection;
		$post_vars = json_decode(file_get_contents("php://input"),true);
		$employee_name=$post_vars["employee_name"];
		$employee_salary=$post_vars["employee_salary"];
		$employee_age=$post_vars["employee_age"];
		
		$response=array(
			'status' => 1,
			'status_message' =>'Employee Updated Successfully.'
		);
			
		header('Content-Type: application/json');
		http_response_code(204);
		echo json_encode($response);
	}
	
	function delete_employee($id)
	{
		$response=array(
			'status' => 1,
			'status_message' =>'Employee Deleted Successfully.'
		);
		header('Content-Type: application/json');
		echo json_encode($response);
	}

?>