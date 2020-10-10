<?php

class Login { //login class (contains method that enables login)

	private $conn;
	private $adminTable = 'sirimazone_admins';
	private $accessIdTable = 'sirimazone_access_id';
	
	//constructor with database
	public function __construct($db) {
		$this->conn = $db;
	}

	public  function getAdminUser($username = null) {

		$query = 'SELECT * FROM '.$this->adminTable.' WHERE username = ?';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(1, $username);
        //$stmt->bindValue(2, $password);

        //Execute query
        $stmt->execute();

        return $stmt;
	}

	public  function getAllAdminUser() {

		$query = 'SELECT * FROM '.$this->adminTable;

		//prepare statement
		$stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
	}

	public function getAccessId($accessName = null) {

		$query = 'SELECT * FROM '. $this->accessIdTable.' WHERE access_name = :access_name';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':access_name', $accessName);

		//execute query
		$stmt->execute();

		return $stmt;
	}


	public function updateAccessIdUsedStatus($accessName) {

		$query = ' UPDATE '. $this->accessIdTable . ' SET is_used = 1 WHERE '.$this->accessIdTable . '.access_name = :access_name ';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':access_name', $accessName);


		// Execute query
		if($stmt->execute()) {
			return true;
		}

		// Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);

		return false;

	}




	//checks if an admin exist with given username and email

	public function checkIfUsernameExists($username = null) {

		//set the query
		$query = 'SELECT * FROM ' . $this->adminTable . ' WHERE username = :username LIMIT 1';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':username', $username);

		//execute query
		$stmt->execute();

		//get statement object result
		$result = $stmt->fetch(PDO::FETCH_OBJ);

		return $result;

	}


	public function checkIfEmailExists($email = null) {

		//set the query
		$query = 'SELECT * FROM ' . $this->adminTable . ' WHERE email = :email LIMIT 1';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':email', $email);

		//execute query
		$stmt->execute();

		//get statement object result
		$result = $stmt->fetch(PDO::FETCH_OBJ);

		return $result;

	}


   //adds admins to the db
	public function addAdminUser($username, $email, $password) {

		$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

		$query = "INSERT INTO ". $this->adminTable ."(`username`, `email`, `password`) VALUES (:username, :email, :password)";

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':username', $username);
		$stmt->bindValue(':email', $email);
		$stmt->bindValue(':password', $hashedPassword);

		// Execute query
		if($stmt->execute()) {
			return true;
		}

		// Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);

		return false;

	}

	public static function logout() {
		session_start();
		session_destroy();
		header('Location: ../');
	}

	public function escapeString($string) {
	$escaped = htmlspecialchars(strip_tags($string));
	return $escaped;
}

}