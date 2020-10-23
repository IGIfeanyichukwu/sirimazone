<?php 
session_start();

$stepToRoot = '../';

$pageTitle = 'Delete Post Comment - Sirimazone';

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

	//get username
	$loggedInUsername = $_SESSION['logged_in_sirimazone_username'];

//get array of all content post
// $contentPostArr = $content->getAllContentPost();
$contentPostArr = $content->getAllContentPostByUser($loggedInUsername);


if(isset($_POST['delete-comment-post-btn'])) {
	$gottenCommentID = $_POST['comment-id'];
	// echo $gottenCommentID;

	if ($content->deletePostCommentByCommentID($gottenCommentID)) {

		echo "<script>
				if( window.history.replaceState) {
					window.history.replaceState( null, null, window.location.href );
				}
	    		document.querySelector('.modal-bg').classList.add('show-modal-bg');
				mdtoast('Comment deleted successfully.', {
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

			mdtoast('Comment not deleted. Pls try again', {
				duration: 4000,
	  			type: 'error'
			});
		</script>";
	}
}


?>

<h3 class="page-title"><span><a href="<?php echo './profile/'.$loggedInUsername; ?>"><i class="fas fa-arrow-left"></i></a></span> Delete Post Comment</h3>

<p>You can fetch comments from a post and then delete afterwards here.</p>

<div class="alert-role-box">
	<b>NB:</b> You can only delete comments under your posts.
</div>



<div class="select-comment-post-form-div">
	
	<form action="" method="post" id="select-comment-post-form">
		<select name="select-comment-post-input" required>
			<option value="">--select a post to fetch comments from--</option>
			<?php 
			foreach ($contentPostArr as $contentPost) {
				extract($contentPost);
			?>
				<option value="<?php echo $content_slug; ?>"><?php echo $content_title; echo ' ('.$content_category .'/'; echo $is_published == '0' ? 'Not-Published' : 'Published'; echo ')';  ?></option>

			<?php
			}

			?>
		</select>
		<div>
			<button type="submit" name="select-comment-post-btn">Fetch Comments</button>
		</div>

	</form>
</div>

<div class="delete-post-comment-div">

	<?php 

if(isset($_POST['select-comment-post-btn'])) {
	$commentSlug = $_POST['select-comment-post-input'];

	$gottenPostFromSlug = $content->getPostBySlug($commentSlug);

	//get all comments by given slug
	$gottenComments = $content->getAllPostCommentsBySlug($commentSlug);

	echo '<br>';
	if ($gottenComments == null) {
		echo '<p>No <b>comments</b> under <b>'. $gottenPostFromSlug['content_title'] .'</b></p>';
		echo "<script>
			mdtoast('No comments fetched or found under ". $gottenPostFromSlug['content_title'] ."', {
				duration: 5000,
	  			type: 'warning'
			});
		</script>";
	} else {
		echo '<p>All <b>' . count($gottenComments) . '</b>  comments under <b>'. $gottenPostFromSlug['content_title'] .'</b></p>';
		echo "<script>
			mdtoast('". count($gottenComments) ." comments fetched under ". $gottenPostFromSlug['content_title'] ."', {
				duration: 5000,
	  			type: 'success'
			});
		</script>";
		// var_dump($gottenComments);

		?>

<table>
	<thead>
		<tr>
			<th>S/N</th>
			<th>Comment</th>
			<th>Comment Author</th>
			<th>Time Created</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 

		$comCount = 0;

		foreach ($gottenComments as $comment) {
		$comCount++;
		$commentTime = $comment['creation_timestamp'];
		?>
			<tr>
				<td><?php echo $comCount; ?></td>
				<td><?php echo $comment['comment_body']; ?></td>
				<td><?php echo $comment['comment_author']; ?></td>
				<td><?php echo date('M j, y', $commentTime) . ' at ' . date('g:i a', $commentTime); ?></td>
				<td>
					<form action="" method="post">
						<input type="hidden" name="comment-id" value="<?php echo $comment['comment_id']; ?>">
						<input type="hidden" name="real-comment-id" value="<?php echo $comment['id']; ?>">
						<button type="submit" name="delete-comment-post-btn">Delete Comment</button>
					</form>
				</td>
			</tr>

		<?php
		}

		?>
	</tbody>
</table>



		<?php


	}

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