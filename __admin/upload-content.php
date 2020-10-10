<?php 

$stepToRoot = '../';

//add jquery and upload js scripts
$usejQuery = true;
$useAjaxUpload = true;

//handleUploads
$upload = 'err';
if(!empty($_FILES['file'])) {
	//file upload configuration
	$targetDir = "../uploadz/";
	$allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'gif');

	$fileName = basename($_FILES['file']['name']);
	$targetFilePath = $targetDir.$fileName;

	//check whether file type is valid
	$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
	if(in_array($fileType, $allowTypes)) {
		//upload file to the server
		if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
			$upload = 'ok';
		}
	}
}

// echo $upload;




require '../temp/header.php';

?>

<h2>Upload Content</h2>
<p>Select the file you want to upload and click the upload button to upload.</p>

<div class="upload-form">

	<form action="" enctype="multipart/form-data" id="file-upload-form">
		<label for="">Choose File:</label>
		<input type="file" name="uploadfile" id="file-upload-input">
		<input type="submit" name="submit" value="UPLOAD">
	</form>

	<!-- Progress bar -->
	<div class="progress">
		<div class="upload-progress-bar"></div>
	</div>

	<!-- Display upload status -->
	<div id="uploadStatus"></div>
	
</div>


<?php 

require '../temp/footer.php';

?>