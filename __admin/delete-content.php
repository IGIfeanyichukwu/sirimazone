<?php 
session_start();

$stepToRoot = '../';
$pageTitle = 'Delete Content - Sirimazone';

require '../classes/Dbase.php';
require '../classes/Content.php';

 $database = new Dbase();
 $db = $database->connect();
 $content = new Content($db);

require_once '../temp/header.php';


//check if the user is logged in
if(isset($_SESSION['is_logged_into_sirimazone'])) {

	//get username
	$loggedInUsername = $_SESSION['logged_in_sirimazone_username'];


	//get uploaded files statement
	$uploadedFilesStatement = $content->getAllUploadedFiles();

	//get an array of all the uploaded files from all admins
	$uploadedFilesArray = $uploadedFilesStatement->fetchAll();



	//get uploaded files by statement
	$uploadsByStatement = $content->getUploadsBy($loggedInUsername);

	//get an array of all the uploaded files by the logged in admin
	$uploadsByArray = $uploadsByStatement->fetchAll();




	if(isset($_POST['selected-delete-file'])) {

		// echo $_POST['selected-delete-file'];
		$selDelFile = $_POST['selected-delete-file'];

		//upload path
		$uploadPath = '../uploadz/';

		if ($selDelFile != '') {

			if(is_readable($uploadPath.$selDelFile)) {

				if (unlink($uploadPath.$selDelFile)) {
					if ($content->deleteFileFromSQL($selDelFile)) {
						echo "<script>
				    		document.querySelector('.modal-bg').classList.add('show-modal-bg');
							mdtoast('File has successfully been deleted.', {
								duration: 3000,
					  			type: 'success',
					  			modal: true,
					  			interaction: true, 
					  			actionText: 'OK', 
				  				action: function(){

				    		document.querySelector('.modal-bg').classList.remove('show-modal-bg');
				    
				    			this.hide();
				  			}

							});
						</script>";

					} else {
						echo "<script>
							mdtoast('File was deleted from the server directory but not from the sql database. Kindly report to sirimazone technical team.', {
								duration: 3000,
					  			type: 'warning',
					  			interaction: true,
					  			interactionTimeout: 10000,
					  			actionText: 'OK',
					  			action: function(){
								
								    this.hide(); 
								}
							});
						</script>";
					} 
				} else {
					echo "<script>
						mdtoast('Selected File could not be deleted', {
							duration: 3000,
				  			type: 'error'
						});
					</script>";
				}
			} else {
				echo "<script>
						mdtoast('File does not exist on the server', {
							duration: 3000,
				  			type: 'error'
						});
					</script>";
			}

		} else {
			echo "<script>
				mdtoast('No file is selected', {
					duration: 4500,
		  			type: 'error'
				});
			</script>";
		}



	}

?>

<h2 class="page-title"><span><a href="<?php echo './profile/'.$loggedInUsername; ?>"><i class="fas fa-arrow-left"></i></a></span> Delete Content</h2>
<p>To delete a file from Sirimazone's server simply select the file and click the delete button. <small>(Pls give deleting any file a second thought)</small>.</p>
<p class="alert-role-box">Only one file can be deleted at a time. A File can never be recovered when it is deleted. You can only delete files uploaded by you.</p>

<div class="file-delete-div">
	<form action="" method="post" id="file-delete-form">
		<label for="file-delete">Select a file from your uploads:</label>

		<select name="selected-delete-file" id="file-delete">
		    <option value="">--Select a file to be deleted--</option>
		    <?php

	    	foreach ($uploadsByArray as $uploadsByFile) {
	    		$fileName = $uploadsByFile['file_name'];
	    		$fileSize = $uploadsByFile['file_size'];
	    	?>

		    	<option value="<?php echo $fileName; ?>"><?php echo $fileName; echo ' ('.$fileSize.')'; ?></option>

	    	<?php
				
			}

		     ?>
		</select>



		<button type="submit" id="delete-file-btn">Delete File</button>
	</form>

</div>

<div class="all-uploads">
	<p>Below is a list of all uploaded files currently on the server.</p>

	<select name="all-uploads-list" id="all-uploads-list">
		    <?php

	    	foreach ($uploadedFilesArray as $uploadedFile) {
	    		$fileName = $uploadedFile['file_name'];
	    		$fileSize = $uploadedFile['file_size'];
	    		$uploader = $uploadedFile['uploaded_by'];
	    	?>

		    	<option value="<?php echo $uploadedFile['file_name']; ?>"><?php echo $fileName; echo ' ('.$fileSize.')'; echo ' - Uploaded By '.$uploader; ?></option>

	    	<?php
				 
			}

		     ?>
		</select>
</div>


<?php

require_once '../temp/footer.php';


} else {  //if the user is not logged in
    
    //go back to authetication
    header('Location: ./');


}


?>