<?php
	class Employee{
		//conexion a la BD
		private $db;
		private $table_name = "employees";
		
		//definiendo las propiedades
		public $id;
		public $name;
		public $age;
		public $salary;
		
		public function __construct($db){
			$this->db = $db;
		}
		
		//obtener todos los empleados de la base de datos
		function read(){
			//Define la consulta/query
			$query = "SELECT id, name, age, salary 
			          FROM " . $this->table_name 
					  . " ORDER BY id DESC";
			
			//establecer el query statement
			$stmt = $this->db->prepare($query);
			
			//ejecutar la consulta
			$stmt->execute();
			
			return $stmt;
		}
		
		//obtiene un empleado en particular
		function readOne(){
			
		}
		
		//crea o da de alta un empleado
		function create(){
			//Definir la instruccion
			$query = "INSERT INTO " . $this->table_name 
					  . " SET name=:name, age=:age, salary=:salary";
			
			//peparar la consulta
			$stmt = $this->db->prepare($query);
			
			//remover caraceteres especiales y codigo html
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->age = htmlspecialchars(strip_tags($this->age));
			$this->salary = htmlspecialchars(strip_tags($this->salary));
			
			//reemplazar los valores de las etiquetas
			$stmt->bindParam(":name", $this->name);
			$stmt->bindParam(":age", $this->age);
			$stmt->bindParam(":salary", $this->salary);
			
			//ejecutar la consulta
			if($stmt->execute()){
				return true;
			}
			
			//var_dump($stmt->errorInfo());
			return false;
		}
		
		//actualiza la informacion de un empleado en particular
		function update(){
			
		}
		
		//elimina un empleado
		function delete(){
			
		}
	}

?>