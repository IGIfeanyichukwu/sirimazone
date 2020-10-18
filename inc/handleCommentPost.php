<?php 

// echo 'handling comment post';

// Get all the inputs
$commentAuthor = trim($login->escapeString($_POST['comment-author']));
$commentBody = trim($login->escapeString($_POST['comment-body']));

//get other info
$creationTimestamp = time();
$postSlug = $gottenSlug;
$postTitle = $conInfo['content_title'];
$commentID = substr(uniqid(), -6).rand(0, 999).substr(uniqid(), -6).rand(1, 999);

$commentBodyCount = strlen($commentBody);

if ($commentAuthor == '') {
	$commentAuthor = 'Anonymous';
}



//insert data to db
if ($commentBody == '') {

	echo "<script>
				mdtoast('Pls enter a valid comment.', {
					duration: 4000,
		  			type: 'error',
		  			interaction: false, 
		  			actionText: 'OK', 
	  				action: function(){

	    			this.hide();
	  			}

				});
			</script>";

} else if ($commentBodyCount > 4000) {

	echo "<script>
				mdtoast('Comment is too long. Max of 4000 allowed.', {
					duration: 4000,
		  			type: 'error',
		  			interaction: false, 
		  			actionText: 'OK', 
	  				action: function(){

	    			this.hide();
	  			}

				});
			</script>";

} else if ($content->insertCommentToDB($commentID, $postTitle, $postSlug, $commentAuthor, $commentBody, $creationTimestamp)) {

	// header('Location: '. $_SERVER[''] )

	echo "<script>
				if( window.history.replaceState) {
					window.history.replaceState( null, null, window.location.href );
				}
				location.reload();
				mdtoast('Comment added.', {
					duration: 3000,
		  			type: 'success',
		  			interaction: false, 
		  			actionText: 'OK', 
	  				action: function(){
	  				location.reload();

	    			this.hide();
	  			}
				});


				
			</script>";


} else {

		echo "<script>
				mdtoast('Something went wrong, try commenting again.', {
					duration: 4000,
		  			type: 'error',
		  			interaction: false, 
		  			actionText: 'OK', 
	  				action: function(){

	    			this.hide();
	  			}

				});
			</script>";

}