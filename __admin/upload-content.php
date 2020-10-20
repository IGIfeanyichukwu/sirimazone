<?php 
session_start();


$stepToRoot = '../';
$pageTitle = 'Upload Content - Sirimazone';

require '../classes/Dbase.php';
require '../classes/Content.php';

 $database = new Dbase();
 $db = $database->connect();
 $content = new Content($db);

//add jquery and upload js scripts
$usejQuery = true;
$useAjaxUpload = true;

//check if user is logged in
if(isset($_SESSION['is_logged_into_sirimazone'])) {

	$loggedInUsername = $_SESSION['logged_in_sirimazone_username'];

require '../temp/header.php';

?>

<h2 class="page-title"><span><a href="<?php echo './profile/'.$loggedInUsername; ?>"><i class="fas fa-arrow-left"></i></a></span> Upload Content</h2>
<p>To upload a file to Sirimazone's server simply select the file and click the upload button.</p>



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

<div class="upload-guidelines">
	<h4>Guidelines for uploading files</h4>
	<ol>
		<li>Only image(jpg, jpeg, png, gif), music(mp3) and video(3gp, mp4, mkv) files can be uploaded.</li>
		<li>Files can only be uploaded one at a time i.e multiple uploaded is not allowed.</li>
		<li>Uploaded maximum file size is 510mb. Files with size greater that 510mb will not be uploaded.</li>
		<li>If this page gets stuck simply refresh it and try again.</li>
	</ol>

</div>


<?php 

require '../temp/footer.php';

} else {  //if the user is not logged in
    
    //go back to authetication
    header('Location: ./');


}

?>