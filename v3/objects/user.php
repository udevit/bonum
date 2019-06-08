<?php
	class User{
		//conexion a la BD
		private $db;
		private $table_name = "users";
	 
		//definiendo las propiedades
		public $id;
		public $name;
		public $lastname;
		public $email;
		public $password;
	 
		// constructor
		public function __construct($db){
			$this->db = $db;
		}
		
		//validar si el correo existe en el sistema
		function emailExists(){
			$query = "SELECT id, name, lastname, password
					FROM " . $this->table_name . "
					WHERE email = ?
					LIMIT 0,1";
		 
			// preparar la consulta
			$stmt = $this->db->prepare( $query );
		 
			// eliminar caracteres especiales
			$this->email=htmlspecialchars(strip_tags($this->email));
		 
			//reemplazar el valor del email de la etiqueta
			$stmt->bindParam(1, $this->email);
		 
			//ejecutar la consulta
			$stmt->execute();
		 
			// obtener el numero de filas
			$num = $stmt->rowCount();
			
			//Si el email existe, asignar las propiedades del objeto User
			if($num>0){
		 
				/// obtener los valores de las elementos de la BD
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 
				// asignar el valor de las propiedades del objeto
				$this->id = $row['id'];
				$this->name = $row['name'];
				$this->lastname = $row['lastname'];
				$this->password = $row['password'];
		 
				// retornar true si el email existe en la BD
				return true;
			}
		 
			// retornar false si el email no existe en la BD
			return false;
		}
		
	}

?>
