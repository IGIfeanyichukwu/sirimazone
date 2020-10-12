<?php 
session_start();


$stepToRoot = '../';

//add jquery and upload js scripts
$usejQuery = true;
$useAjaxUpload = true;

//check if user is logged in
if(isset($_SESSION['is_logged_into_sirimazone'])) {

require '../temp/header.php';

?>

<h2>Upload Content</h2>
<p>Select the file you want to upload and click the upload button to upload.</p>

<div class="file-upload-div">

	<form action="" method="post" enctype="multipart/form-data" id="file-upload-form">
		<div class="file-input-fc">
			<label for="file-upload-input">Select file</label>
			<div class="file-input-wrap">
			    <!-- MAX_FILE_SIZE must precede the file input field -->
			    <input type="hidden" name="MAX_FILE_SIZE" value="534773760" />
				<input type="file" name="file" id="file-upload-input" class="">
			</div>
		</div>
		<div class="file-submit-fc">
			<!-- <input type="submit" name="submit" value="UPLOAD"> -->
			<button type="submit"><i class="fas fa-cloud-upload-alt"></i> Upload</button>
		</div>
	</form>

	<!-- Progress bar -->
	<div class="file-upload-progress">
		<div class="file-upload-progress-bar"></div>
	</div>

	<!-- Display upload status -->
	<div id="file-upload-status"></div>
	
</div>


<?php 

require '../temp/footer.php';

} else {  //if the user is not logged in
    
    //go back to authetication
    header('Location: ./');


}

?>