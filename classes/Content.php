<?php

class Content { //content class 

	private $conn;
	private $uploadsTable = 'sirimazone_uploads';
	/*private $adminTable = 'sirimazone_admins';
	private $accessIdTable = 'sirimazone_access_id';*/
	
	//constructor with database
	public function __construct($db) {
		$this->conn = $db;
	}

	public function convertByteInString($val) {
		if ($val < 1048576) {
			$convertedVal = number_format($val / 1024, 2).'kb';
			if(substr($convertedVal, -4) == '00kb') {
				return (substr($convertedVal, 0, -5).'kb');
			} else {
				return $convertedVal;
			}
		} else if ($val >= 1048576) {
			$convertedVal = number_format($val / 1048576, 2).'mb';
			if(substr($convertedVal, -4) == '00mb') {
				return (substr($convertedVal, 0, -5).'mb');
			} else {
				return $convertedVal;
			}
		}
	}


	public function uploadToSQL($fileName, $fileExt, $fileSize, $uploader) {

		//set query
		$query = "INSERT INTO ". $this->uploadsTable ."(`file_name`, `file_extension`, `file_size`, `uploaded_by`) VALUES (:file_name, :file_extension, :file_size, :uploaded_by)";

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':file_name', $fileName);
		$stmt->bindValue(':file_extension', $fileExt);
		$stmt->bindValue(':file_size', $fileSize);
		$stmt->bindValue(':uploaded_by', $uploader);

		// Execute query
		if($stmt->execute()) {
			return true;
		}

		return false;

	}


	public function getAllUploadedFiles() {

		$query = 'SELECT * FROM '.$this->uploadsTable;

		//prepare statement
		$stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;

	}

	public function getUploadsBy($username = null) {

		$query = 'SELECT * FROM '.$this->uploadsTable.' WHERE '.$this->uploadsTable.'.uploaded_by = :uploader';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':uploader', $username);

		//execute query
		$stmt->execute();

		return $stmt;

	}

	public function deleteFileFromSQL($fileName) {

		$query = 'DELETE FROM '.$this->uploadsTable.' WHERE file_name = :file_name';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':file_name', $fileName);

		//execute query
		if($stmt->execute()) {
			return true;
		}

		return false;

	}




}