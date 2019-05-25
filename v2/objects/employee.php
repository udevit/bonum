<?php
class Employee{
 
    // database connection and table name
    private $conn;
    private $table_name = "employees";
 
    // object properties
    public $id;
    public $name;
    public $age;
    public $salary;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read employees
	function read(){
		// select all query
		$query = "SELECT
					e.id, e.name, e.age, e.salary
				FROM
					" . $this->table_name . " e
				ORDER BY
					e.id DESC";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}

	// read employee by id
	function readOne(){
		// select all query
		$query = "SELECT
					e.id, e.name, e.age, e.salary
				FROM
					" . $this->table_name . " e WHERE e.id = ? 
				LIMIT
					0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	 
		// bind id of employee to be updated
		$stmt->bindParam(1, $this->id);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		// set values to object properties
		$this->name = $row['name'];
		$this->age = $row['age'];
		$this->salary = $row['salary'];
	}
	
	// create employee
	function create(){
		// query to insert record
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					name=:name, age=:age, salary=:salary";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	
		// sanitize
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->age=htmlspecialchars(strip_tags($this->age));
		$this->salary=htmlspecialchars(strip_tags($this->salary));
	
		// bind values
		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":age", $this->age);
		$stmt->bindParam(":salary", $this->salary);
		
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}
	
	// update the employee
	function update(){
		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					name = :name,
					age = :age,
					salary = :salary
				WHERE
					id = :id";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	
		 // sanitize
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->age=htmlspecialchars(strip_tags($this->age));
		$this->salary=htmlspecialchars(strip_tags($this->salary));
	
		// bind new values
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':age', $this->age);
		$stmt->bindParam(':salary', $this->salary);
		$stmt->bindParam(':id', $this->id);
		
		 // execute the query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}
	
	// delete the employee
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}

}