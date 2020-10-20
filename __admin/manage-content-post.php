<?php 
session_start();

$stepToRoot = '../';

$pageTitle = 'Manage Content Post - Sirimazone';

require '../classes/Dbase.php';
require '../classes/Content.php';
require '../classes/Login.php';

 $database = new Dbase();
 $db = $database->connect();
 $content = new Content($db);
 $login = new Login($db);


//check if the user is logged in
if(isset($_SESSION['is_logged_into_sirimazone'])) {


require_once '../temp/header.php';

if(isset($_POST['content-post-update-btn'])) {
	require_once './inc/handleContentPostUpdate.php';
}


if(isset($_POST['select-delete-post-btn'])) {

	$postToDeleteSlug = $_POST['select-edit-post-input'];
	
	if ($content->deleteContentPostBySlug($postToDeleteSlug)) {
		echo "<script>
				if( window.history.replaceState) {
					window.history.replaceState( null, null, window.location.href );
				}
	    		document.querySelector('.modal-bg').classList.add('show-modal-bg');
				mdtoast('Post deleted successfully.', {
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

			mdtoast('Post not deleted. Pls try again', {
				duration: 4000,
	  			type: 'error'
			});
		</script>";
	}

}


	//get username
$loggedInUsername = $_SESSION['logged_in_sirimazone_username'];


//get array of all content post
// $contentPostArr = $content->getAllContentPost();
$contentPostArr = $content->getAllContentPostByUser($loggedInUsername);



//get image uploads statement
$imageUploadsStatement = $content->getImageUploads();

//get array of all image uploads
$imageUploads = $imageUploadsStatement->fetchAll();



//get non image uploads statment
$nonImageUploadsStatement = $content->getNonImageUploads();

//get array of all non image uploads
$nonImageUploads = $nonImageUploadsStatement->fetchAll();

?>

<h2 class="page-title"><span><a href="<?php echo './profile/'.$loggedInUsername; ?>"><i class="fas fa-arrow-left"></i></a></span> Manage Content Post</h2>

<p>You can edit or delete posts here.</p>

<div class="alert-role-box">
	<b>NB:</b> You can only edit or delete post created by you.
</div>

<div>
	
	<form action="" method="post" id="select-edit-post-form">
		<select name="select-edit-post-input" required>
			<option value="">--select a post to edit or delete--</option>
			<?php 
			foreach ($contentPostArr as $contentPost) {
				extract($contentPost);
			?>
				<option value="<?php echo $content_slug; ?>"><?php echo $content_title; echo ' ('.$content_category .'/'; echo $is_published == '0' ? 'Not-Published' : 'Published'; echo ')';  ?></option>

			<?php
			}

			?>
		</select>
		<button type="submit" name="select-edit-post-btn">Edit Post</button>
		<button type="submit" name="select-delete-post-btn">Delete Post</button>

	</form>
</div>

<div class="edit-post-form-div">
	
<?php 

if(isset($_POST['select-edit-post-btn'])) {
	$postToEditSlug = $_POST['select-edit-post-input'];

	//get post by give slug
	$gottenPost = $content->getPostBySlug($postToEditSlug);

	// var_dump($gottenPostBySlug);
	//create an array of categories
	$categories = array('Hollywood', 'Nollywood', 'Bollywood', 'Others');

	echo "<script>
			mdtoast('". $gottenPost['content_title'] ." Post fetched and ready for edit.', {
				duration: 5000,
	  			type: 'success'
			});
		</script>";

	?>

	<form action="" method="post" id="content-post-form">


		<input type="hidden" name="current-post-slug" id="current-post-slug" value="<?php echo $gottenPost['content_slug']; ?>" >
		<input type="hidden" name="current-post-title" id="current-post-title" value="<?php echo $gottenPost['content_title']; ?>" >
		<input type="hidden" name="current-post-id" id="current-post-id" value="<?php echo $gottenPost['id']; ?>" >


		<div class="content-title-wrap">
			<label for="content-title">Content title</label>
			<!-- <p>Changing the title of the post will affect the post's URI as well.</p> -->
			<input type="text" name="content-title" id="content-title" placeholder="content title" value="<?php echo $gottenPost['content_title']; ?>" required>
		</div>

		<div class="content-cover-wrap">
			<label for="content-cover">Content cover image</label>
			<!-- <p>Select the cover image for this content post <small>(It is advised that every post should have one.)</small>. Only uploaded image files are in the list. If you are yet to upload the cover image for this post please, do so in the <a href="./upload-content">upload content section</a>.</p> -->
			<select name="content-cover" id="content-cover" required>
				<option value="<?php echo $gottenPost['content_cover_image'];  ?>"><?php echo $gottenPost['content_cover_image'];  ?></option>
				<?php
				foreach ($imageUploads as $imageUpload) {
					if ($imageUpload['file_name'] != $gottenPost['content_cover_image']) {
				?> 

					<option value="<?php echo $imageUpload['file_name']; ?>"><?php echo $imageUpload['file_name']; echo ' ('.$imageUpload['file_size'].')'; ?></option>

				<?php

					}
				}

				?>
			</select>
		</div>

		<div class="content-cover-alt-wrap">
			<label for="content-cover-alt">Content cover alt text</label>
			<input type="text" name="content-cover-alt" id="content-cover-alt" placeholder="content cover alternative text" value="<?php echo $gottenPost['content_cover_image_alt']; ?>" required>
		</div>


		<div class="content-category">
			<label for="content-category">Content category</label>
			<select name="content-category" id="content-category" required>
				<option value="<?php echo $gottenPost['content_category']; ?>"><?php echo $gottenPost['content_category']; ?></option>
				<?php
				foreach ($categories as $category) {
					if ($category != $gottenPost['content_category']) {
				?> 
					<option value="<?php echo $category; ?>"><?php echo $category; ?></option>

				<?php

					}
				}

				?>
			</select>
		</div>


		<div class="content-file">
			<label for="content-file">Content file</label>
			<!-- <p>Select the video file for this post from the list below. This will be made downloadable. If the file is also in another (external) server and you want to include it, paste all the links to the external file in a comma-separated format in the next form control.</p> -->
			<select name="content-file" id="content-file">
			<?php
			if ($gottenPost['content_main_file'] != '') {
					?>
				<option value="<?php echo $gottenPost['content_main_file']; ?>"><?php echo $gottenPost['content_main_file']; ?></option>
				<?php

			} else {
				?>

				<option value="">--select a category for the content--</option>

				<?php
			}

				foreach ($nonImageUploads as $nonImageUpload) {

					if ($nonImageUpload['file_name'] != $gottenPost['content_main_file']) {

				?> 

				<option value="<?php echo $nonImageUpload['file_name']; ?>"><?php echo $nonImageUpload['file_name']; echo ' ('.$nonImageUpload['file_size'].')'; ?></option>

				<?php
				}
				}

				?>

			</select>
		</div>

		<div class="content-external-file">
			<label for="content-external-file">Content External File</label>
			<!-- <p>If there are other servers that hosts the content file aside sirimazone's server paste the links below in a comma-separated format.</p> -->
			 <input type="text" name="content-external-file" id="content-external-file" placeholder="input all external links in comma-separated format..." value="<?php echo $gottenPost['content_main_file_ext_server']; ?>">
		</div>

		<div class="content-casts">
			<label for="content-casts">Content casts</label><br>
			<!-- <p>Input the casts of this content in a comma-separated format below.</p> -->
			<textarea name="content-casts" id="content-casts" placeholder="content casts..."><?php echo $gottenPost['content_casts']; ?></textarea>
		</div>

		<div class="content-overview">
			<label for="content-overview">Content overview</label><br>
			 <textarea name="content-overview" id="content-overview" placeholder="write something about the content..." required><?php echo $gottenPost['content_overview']; ?></textarea> 
		</div>

		<div class="publish-status">
			<label for="publish-status">Publish content post</label>
			<select name="publish-status" id="publish-status">
				<?php 
				if ($gottenPost['is_published'] == 0) {
				 ?>
					<option value="0">no</option>
					<option value="1">yes</option>
				<?php
				} if($gottenPost['is_published'] == 1) {
				 ?>
					<option value="1">yes</option>
					<option value="0">no</option>
				<?php
				}

				?>
			</select>

		</div>

		<div class="pin-status">
			<label for="pin-status">Pin content post</label>
			<select name="pin-status" id="pin-status">
				<?php 
				if ($gottenPost['is_pinned'] == 0) {
				 ?>
					<option value="0">no</option>
					<option value="1">yes</option>
				<?php
				} if($gottenPost['is_pinned'] == 1) {
				 ?>
					<option value="1">yes</option>
					<option value="0">no</option>
				<?php
				}

				?>
			</select>

		</div>



		<div class="content-post">
			<button type="submit" name="content-post-update-btn" id="content-post-update-btn">Update Post</button>
		</div>



	
	</form>



<?php



}

?>
</div>





<?php

require_once '../temp/footer.php';


} else {  //if the user is not logged in
    
    //go back to authetication
    header('Location: ./');


}


?>