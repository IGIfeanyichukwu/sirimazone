<?php


//handleUploads
$uploadRes = 'err';
if(!empty($_FILES['file'])) {
	//file upload configuration

	$maxSize = 534773760; //510megabytes

	// $maxSize = 22;

	//set the upload path
	$targetDir = "../uploadz/";

	//define allowed file extensions
	$allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'mp3', '3gp', 'mp4', 'mkv');



	$fileName = basename($_FILES['file']['name']);

	$fileSize = $_FILES['file']['size'];

	$targetFilePath = $targetDir.$fileName;

	//get the file's extesion
	$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

	//get the file's name with underscore in place of space
	$fileRealName = str_replace(" ", "_", pathinfo($targetFilePath, PATHINFO_FILENAME));

	//generate a random 9 digit value
	$randVal = substr(uniqid(), -6).rand(1, 999).'_sirimazone.com';

	//get the file's extension in lower case
	$fileExt = strtolower($fileType);

	//rename file but set length to 150 if greater than 150
	if(strlen($fileRealName) > 150) {

	$newFileName = $targetDir.substr($fileRealName, 0, 150).$randVal.'.'.$fileExt;

	} else {

	//rename file
	$newFileName = $targetDir.$fileRealName.$randVal.'.'.$fileExt;

	}

	
	if(in_array($fileExt, $allowTypes)) {

		if($fileSize >= $maxSize) { //if the file is greater than the set max size
			$uploadRes = 'max_size_err';
		} else {

			//upload file to the server
			if(move_uploaded_file($_FILES['file']['tmp_name'], $newFileName)) {
				$uploadRes = 'ok';
			}

		}
	}
}

echo $uploadRes;