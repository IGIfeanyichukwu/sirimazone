<?php 
session_start();

require './classes/Dbase.php';
require './classes/Content.php';
require './classes/Login.php';

$stepToRoot = '../';

 $database = new Dbase();
 $db = $database->connect();
 $content = new Content($db);
 $login = new Login($db);

 // $uploadDir = "./uploadz/";



 //get the slug from url
 $gottenSlug = isset($_GET['slug']) ? $_GET['slug'] : null;




//getting the request uri of the page
$reqUri = $_SERVER['REQUEST_URI'];

//break the reqUri into parts
$expUri = explode("/", $reqUri);

//get the last part of the URI
$lstUri = $expUri[count($expUri) - 1];
$querysign = '?';
//confirm the existence of a '?' in the last part of the URI
$qsPos = strpos($lstUri, $querysign);


//get array of all published post's slug
$slugArr = $content->getAllPublishedPostsSlug();

//set a container for all real slugs
$realSlugArr = array();
/*
echo 'last uri is '.$lstUri;
echo '<br> and gotten slug is '. $gottenSlug;*/


foreach ($slugArr as $slug) {
	//add real slug to the container
	array_push($realSlugArr, $slug[0]);
}

$conInfo = $content->getPostBySlug($gottenSlug);

$uploadDir = '../uploadz/';


if (isset($_GET['slug']) && $qsPos == true || $lstUri != $gottenSlug) {
		//redirect to 404
	header('Location: ../404');

} else if(in_array($gottenSlug, $realSlugArr)) {

$pageTitle = $conInfo['content_title'] . ' - Sirimazone';

require_once './temp/header.php';

extract($content->getFilesizeByFilename($conInfo['content_main_file']));

//COMMENTS
//get array of comments
$commentArr = $content->getAllPostCommentsBySlug($gottenSlug);


$timeStamp = $conInfo['created_at'];


//handle comment posts
if(isset($_POST['comment-post-btn'])) {
	require_once './inc/handleCommentPost.php';
}

?>

<h3 class="content-title"><?php echo $conInfo['content_title']; ?></h3>
<p>
	<small><i class="fas fa-user"></i> <span><?php echo ucwords($conInfo['content_author']); ?></span></small> &nbsp; 
	<small><i class="fas fa-calendar-alt"></i> <span><?php echo date('F j, Y', $timeStamp); ?></span></small> &nbsp;
	<small><a href="<?php echo '../category/'. strtolower($conInfo['content_category']); ?>"><i class="fas fa-folder-open"></i> <span><?php echo $conInfo['content_category']; ?></span></a></small> &nbsp;
	<small><a href="#"><i class="fas fa-comments"></i> <span><?php echo count($commentArr). ' Comments '; ?></span></a></small>

</p>
<br>
<p><i>mp4/mkv <?php echo $conInfo['content_title']; ?>🔥, Download</i></p>

<div class="single-pg-cover-wrap">
	<img src="<?php echo $uploadDir. $conInfo['content_cover_image']; ?>" alt="<?php echo $conInfo['content_cover_image_alt']; ?>">
</div>

<div class="single-pg-overview">
	<p><?php echo $conInfo['content_overview']; ?></p>
</div>

<div class="sigle-pg-casts">
	<p><i>Casts: <?php echo $conInfo['content_casts']; ?></i></p>
</div>

<div>
	<h5>FILE INFO</h5>
	<ul>
		<li><i>Filename: <?php echo $conInfo['content_main_file']; ?></i></li>
		<li><i>Filesize: <?php echo $file_size; ?></i></li>
	</ul>
</div>

<div>
<?php if($conInfo['content_main_file'] != null) { ?>

	<h5>DOWNLOAD LINK</h5>

	<p><a href="<?php echo $uploadDir . $conInfo['content_main_file']; ?>" download>Download</a></p>

<?php 

	}

if( $conInfo['content_main_file_ext_server'] != null) {

	$linkArr = explode(';', $conInfo['content_main_file_ext_server']); 

?>
	<h5>OTHER DOWNLOAD LINKS</h5>
	<p>
	<?php 

	for($i = 0; $i < count($linkArr); $i++) {
		?>

		<a href="<?php echo $linkArr[$i]; ?>" title="<?php echo '[SERVER '.($i + 1).']' ?>" target="_blank" rel="noopener noreferrer"><?php echo '[SERVER '.($i + 1).']' ?></a> <?php if ($i != (count($linkArr) - 1)) { ?>||<?php } ?> 

	<?php
	}

	?>
		
	</p>

<?php } ?>
	
</div>

<br><br>

<div>
	<span><?php if($commentArr != null) {
		echo count($commentArr). ' Comments ';
	} else {
		echo '0 Comments, Be the first to add a comment. ';
	} ?></span>
	<span>Add a comment</span>
</div>

<?php 

if($commentArr != null) {


// print_r($commentArr);
foreach ($commentArr as $comment) {

	$commentTime = $comment['creation_timestamp'];

?>

<div class="single-comment">
	<div class="comment-gravater"><span><i class="fas fa-user"></i></span></div>
	<div>
		<div class="posted-comment-body">
			<p><b><?php echo $comment['comment_author']; ?></b></p>

			<p><?php echo $comment['comment_body']; ?></p>
			
		</div>
		<div class="posted-comment-time">
			<span><small><?php echo date('F j, Y', $commentTime) . ' at ' . date('g:i a', $commentTime); ?></small></span>			
		</div>
	</div>
</div>

<?php

}


}

?>

<br>
<div class="comment-section">

	<div>
		<p>Add a comment here</p>		
	</div>
	
	<div class="comment-div">
		<form action="" method="post">
			<div>
				<label for="comment-author">Name</label>
				<input type="text" name="comment-author" id="comment-author">
			</div><br>
			<div>
				<label for="comment-text">Comment</label>
				<textarea name="comment-body" id="comment-body" required></textarea>
			</div>
			<div>
				<button type="submit" name="comment-post-btn">Post Comment</button>
			</div>
		</form>
	</div>
</div>
	
                
<?php

require_once './inc/extraFooter.php';

require_once './temp/footer.php'; 

} else {
	
	//redirect to 404
	header('Location: ../404');
}


?>