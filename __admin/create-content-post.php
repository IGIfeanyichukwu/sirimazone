<?php 
session_start();

$stepToRoot = '../';
$pageTitle = 'Create Content Post - Sirimazone';

require '../classes/Dbase.php';
require '../classes/Content.php';
require '../classes/Login.php';

 $database = new Dbase();
 $db = $database->connect();
 $content = new Content($db);
 $login = new Login($db);


require_once '../temp/header.php';


//check if the user is logged in
if(isset($_SESSION['is_logged_into_sirimazone'])) {

	//get image uploads statement
	$imageUploadsStatement = $content->getImageUploads();

	//get array of all image uploads
	$imageUploads = $imageUploadsStatement->fetchAll();



	//get non image uploads statment
	$nonImageUploadsStatement = $content->getNonImageUploads();

	//get array of all non image uploads
	$nonImageUploads = $nonImageUploadsStatement->fetchAll();

	// print_r($nonImageUploads);

	if(isset($_POST['content-post-btn'])) {
		require_once './inc/handleContentPostCreation.php';
	}

	//get username
	$loggedInUsername = $_SESSION['logged_in_sirimazone_username'];

?>

<h2 class="page-title"><span><a href="<?php echo './profile/'.$loggedInUsername; ?>"><i class="fas fa-arrow-left"></i></a></span> Create Content Post</h2>

<!-- <p>You can create a content post below. Provide the content's cover image.</p> -->


<div class="content-post-div">

	<form action="" method="post" id="content-post-form">
		<div class="content-title-wrap">
			<label for="content-title">Content title</label>
			<input type="text" name="content-title" id="content-title" placeholder="content title" required>
		</div>

		<div class="content-cover-wrap">
			<label for="content-cover">Content cover image</label>
			<!-- <p>Select the cover image for this content post <small>(It is advised that every post should have one.)</small>. Only uploaded image files are in the list. If you are yet to upload the cover image for this post please, do so in the <a href="./upload-content">upload content section</a>.</p> -->
			<select name="content-cover" id="content-cover" required>
				<option value="">--select content's cover image--</option>
				<?php
				foreach ($imageUploads as $imageUpload) {
				?> 

				<option value="<?php echo $imageUpload['file_name']; ?>"><?php echo $imageUpload['file_name']; echo ' ('.$imageUpload['file_size'].')'; ?></option>

				<?php
				}

				?>
			</select>
		</div>

		<div class="content-cover-alt-wrap">
			<label for="content-cover-alt">Content cover alt text</label>
			<input type="text" name="content-cover-alt" id="content-cover-alt" placeholder="content cover alternative text" required>
		</div>


		<div class="content-category">
			<label for="content-category">Content category</label>
			<select name="content-category" id="content-category" required>
				<option value="">--select a category for the content--</option>
				<option value="Hollywood">Hollywood</option>
				<option value="Nollywood">Nollywood</option>
				<option value="Bollywood">Bollywood</option>
				<option value="Others">Others</option>
			</select>
		</div>


		<div class="content-file">
			<label for="content-file">Content file</label>
			<!-- <p>Select the video file for this post from the list below. This will be made downloadable. If the file is also in another (external) server and you want to include it, paste all the links to the external file in a comma-separated format in the next form control.</p> -->
			<select name="content-file" id="content-file">
				<option value="">--select a category for the content--</option>

				<?php
				foreach ($nonImageUploads as $nonImageUpload) {
				?> 

				<option value="<?php echo $nonImageUpload['file_name']; ?>"><?php echo $nonImageUpload['file_name']; echo ' ('.$nonImageUpload['file_size'].')'; ?></option>

				<?php
				}

				?>

			</select>
		</div>

		<div class="content-external-file">
			<label for="content-external-file">Content External File</label>
			<!-- <p>If there are other servers that hosts the content file aside sirimazone's server paste the links below in a comma-separated format.</p> -->
			 <input type="text" name="content-external-file" id="content-external-file" placeholder="input all external links in comma-separated format...">
		</div>

		<div class="content-casts">
			<label for="content-casts">Content casts</label><br>
			<!-- <p>Input the casts of this content in a comma-separated format below.</p> -->
			<textarea name="content-casts" id="content-casts" placeholder="content casts..."></textarea>
		</div>

		<div class="content-overview">
			<label for="content-overview">Content overview</label><br>
			 <textarea name="content-overview" id="content-overview" placeholder="write something about the content..." required></textarea> 
		</div>




		<div class="immediate-publish">
			<label for="immediate-publish">Publish immediately</label>
			<select name="immediate-publish" id="immediate-publish">
				<option value="0">no</option>
				<option value="1">yes</option>
			</select>

		</div>

		<div class="content-post">
			<button type="submit" name="content-post-btn" id="content-post-btn">Post</button>
		</div>



	
	</form>

</div>



<?php

require_once '../temp/footer.php';


} else {  //if the user is not logged in
    
    //go back to authetication
    header('Location: ./');


}


?>