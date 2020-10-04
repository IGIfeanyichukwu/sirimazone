<?php

class Login { //login class (contains method that enables login)

	private $conn;
	private $table = 'sirimazone_admins';
	
	//constructor with database
	public function __construct($db) {
		$this->conn = $db;
	}

	public  function getAdminUser($username = null) {

		$query = 'SELECT * FROM '.$this->table.' WHERE username = ?';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(1, $username);
        //$stmt->bindValue(2, $password);

        //Execute query
        $stmt->execute();

        return $stmt;
	}

	public static function logout() {
		session_start();
		session_destroy();
		header('Location: ../index.php');
	}

	public function escapeString($string) {
	$escaped = $this->conn->quote($string);
	return $escaped;
}

}