<?php 

//get some current details
$currentPostTitle = $_POST['current-post-title']; 
$currentPostSlug = $_POST['current-post-slug'];
$currentPostID = $_POST['current-post-id'];


// Get all the inputs
$contentTitle = trim($login->escapeString($_POST['content-title']));

$contentCover = trim($login->escapeString($_POST['content-cover']));

$contentCoverAlt = trim($login->escapeString($_POST['content-cover-alt']));

$contentCategory = trim($login->escapeString($_POST['content-category']));

$contentFile = trim($login->escapeString($_POST['content-file']));

$contentExternalFile = str_replace(' ', '', trim($login->escapeString($_POST['content-external-file'])));

$contentOverview = trim($login->escapeString($_POST['content-overview']));

$contentCasts = trim($login->escapeString($_POST['content-casts']));

$isPublished = $_POST['publish-status'];
$isPinned = $_POST['pin-status'];

//create a content slug
$contentSlug = $contentTitle === $currentPostTitle ? $currentPostSlug : $content->createSlug($contentTitle);

//create current timestamp
$currentTimestamp = time();

$inputArr = array(
	'content title' => $contentTitle,
	'content slug' => $contentSlug,
	'content cover' => $contentCover,
	'content cover alt' => $contentCoverAlt,
	'content category' => $contentCategory,
	'content file' => $contentFile,
	'content external file' => $contentExternalFile,
	'content overview' => $contentOverview,
	'content casts' => $contentCasts
);

// echo $currentPostSlug . ' - ' . $currentPostTitle . ' - '. $currentPostID ;
// echo '<br>';
// echo $contentSlug;
// print_r($inputArr);

if ($contentFile == '' && $contentExternalFile == '') {
	echo "<script>

		mdtoast('No selected file or external links', {
			duration: 4000,
  			type: 'error'
		});
	</script>";


} else {
	//insert into database

	if($content->updateContentPostInDB($currentPostID, $contentTitle, $contentSlug, $contentCover, $contentCoverAlt, $contentCategory, $contentFile, $contentExternalFile, $contentOverview, $contentCasts, $isPublished, $isPinned, $currentTimestamp)) {

		echo "<script>
				if( window.history.replaceState) {
					window.history.replaceState( null, null, window.location.href );
				}
	    		document.querySelector('.modal-bg').classList.add('show-modal-bg');
				mdtoast('Post updated successfully.', {
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

			mdtoast('Post not updated. Pls try again', {
				duration: 4000,
	  			type: 'error'
			});
		</script>";

	}

}