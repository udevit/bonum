<?php
	class Database{
		
		//variables de conexion a la BD
		private $host = "localhost";
		private $db_name = "bonum";
		private $user_name = "root";
		private $password = "";
		public $conn;
		
		//obtiene la conexion a la BD
		public function getConnection(){
			$this->conn = null;
			
			try{
				//mysql:host=localhost;dbname=bonum
				$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name,$this->user_name, $this->password);
				$this->conn->exec("set names utf8");
			}catch(PDOException $ex){
				echo "Error de Conexion a la BD: " .$ex->getMessage();
			}
			
			return $this->conn;
		}
		
	}
?>