<?php

class Dbase { //the database class

	private $_user = "root";
	private $_password = "password";
	private $dsn = "mysql:dbname=sirimazone_sql_dbase;host=localhost";
	private $conn;

	
	public function connect() { //connects to the database and returns a pdo object
		$this->conn = null;
		try {
		    $this->conn = new PDO($this->dsn, $this->_user, $this->_password);
		    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    echo 'connected to the database <br>';
		} catch (PDOException $e) {
		    exit ('Database Error: ' . $e->getMessage());
		}

		return $this->conn; // return pdo object

	}


}