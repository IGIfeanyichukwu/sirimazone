<?php 
session_start();

$stepToRoot = '../';

require './classes/Dbase.php';
require './classes/Content.php';

 $database = new Dbase();
 $db = $database->connect();
 $content = new Content($db);

 $uploadDir = "../uploadz/";

 //get the category from url
 $gottenCategory = isset($_GET['catt']) ? $_GET['catt'] : null;

 $categoryArr = array('hollywood', 'nollywood', 'bollywood', 'others');

 //getting the request uri of the page
$reqUri = $_SERVER['REQUEST_URI'];

//break the reqUri into parts
$expUri = explode("/", $reqUri);

//get the last part of the URI
$lstUri = $expUri[count($expUri) - 1];
$querysign = '?';
//confirm the existence of a '?' in the last part of the URI
$qsPos = strpos($lstUri, $querysign);


if (isset($_GET['catt']) && $qsPos == true) {

		//redirect to 404
	header('Location: ../404');

} else if(in_array($gottenCategory, $categoryArr)) {

//set active nav links
switch ($gottenCategory) {
	case 'hollywood':
		$activateHolly = true;
		$pageTitle = 'Hollywood Category - Sirimazone';
		break;

	case 'nollywood':
		$activateNolly = true;
		$pageTitle = 'Nollywood Category - Sirimazone';
		break;

	case 'bollywood':
		$activateBolly = true;
		$pageTitle = 'Bollywood Category - Sirimazone';
		break;

	case 'others':
		$activateOthers = true;
		$pageTitle = 'Others Category - Sirimazone';
		break;
	
	default:

		break;
}

require_once './temp/header.php'; 

$publishedCatPosts = $content->getPublishedPostByCat($gottenCategory);

?>

<h3>Category: <?php echo ucwords($gottenCategory); ?></h3>

<div class="category-posts">

		<?php

		if ($publishedCatPosts != null) {

		foreach ($publishedCatPosts as $publishedCatPost) {
			$timeStamp = $publishedCatPost['created_at'];
		?>

		<div>
			<div class="cat-cover-image-wrap">
				<img width="250px" src="<?php echo $uploadDir.$publishedCatPost['content_cover_image']; ?>" alt="">
			</div>
			<div class="cat-brief-details">
				<h4><a href="<?php echo '../contents/' . $publishedCatPost['content_slug']; ?>"><?php echo $publishedCatPost['content_title']; ?></a></h4>
				<p><small><i class="fas fa-calendar-alt"></i><?php echo date('F j, Y', $timeStamp); ?> </small> <small><i class="fas fa-folder-open"></i><?php echo $publishedCatPost['content_category']; ?></small></p>
			</div>
		</div>

		<?php
		}

	} else {
		echo '<p>No content under ' . $gottenCategory . ' yet.</p>';
	}

		?>
	</div>






	
                
<?php 
require_once './inc/extraFooter.php';

require_once './temp/footer.php'; 

} else {

	//redirect to 404
	header('Location: ../404');
}



?>