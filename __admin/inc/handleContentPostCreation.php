<?php 

// Get all the inputs
$contentTitle = trim($login->escapeString($_POST['content-title']));

$contentCover = trim($login->escapeString($_POST['content-cover']));

$contentCoverAlt = trim($login->escapeString($_POST['content-cover-alt']));

$contentCategory = trim($login->escapeString($_POST['content-category']));

$contentFile = trim($login->escapeString($_POST['content-file']));

$contentExternalFile = str_replace(' ', '', trim($login->escapeString($_POST['content-external-file'])));

$contentOverview = trim($login->escapeString($_POST['content-overview']));

$contentCasts = trim($login->escapeString($_POST['content-casts']));

$immediatePublish = trim($login->escapeString($_POST['immediate-publish']));

//get logged in user
$loggedInUsername = $_SESSION['logged_in_sirimazone_username'];

//create a content slug
$contentSlug = $content->createSlug($contentTitle);

//create current timestamp
$currentTimestamp = time();

$inputArr = array(
	'content title' => $contentTitle,
	'content cover' => $contentCover,
	'content category' => $contentCategory,
	'content file' => $contentFile,
	'content external file' => $contentExternalFile,
	'content overview' => $contentOverview,
	'content casts' => $contentCasts,
	'content immediate publish' => $immediatePublish
);

// print_r($inputArr);

if ($contentFile == '' && $contentExternalFile == '') {
	echo "<script>

		mdtoast('No selected file or external links', {
			duration: 4000,
  			type: 'error'
		});
	</script>";


} else if($content->checkForDuplicatePosts($contentTitle) > 0) {
	echo "<script>

		mdtoast('A post already exists with this title', {
			duration: 4000,
  			type: 'error'
		});
	</script>";

} else {
	//insert into database

	if($content->insertPostToDB($contentTitle, $contentSlug, $contentCover, $contentCoverAlt, $contentCategory, $loggedInUsername, $contentFile, $contentExternalFile, $contentOverview, $contentCasts, $immediatePublish, $currentTimestamp)) {

		echo "<script>
	    		document.querySelector('.modal-bg').classList.add('show-modal-bg');
				mdtoast('Post has been created successfully', {
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

			mdtoast('Post creation was not successful. Pls try again', {
				duration: 4000,
	  			type: 'error'
			});
		</script>";

	}


}

