<?php 
session_start();

$stepToRoot = '../../';

require './classes/Dbase.php';
require './classes/Content.php';

 $database = new Dbase();
 $db = $database->connect();
 $content = new Content($db);

$publishedPostsStatement = $content->getPublishedContentPost();

 $publishedPosts = $publishedPostsStatement->fetchAll();


 $resultsPerPage = 18;

 $uploadDir = "../../uploadz/";

 //get the category from url
 $gottenCategory = isset($_GET['catt']) ? $_GET['catt'] : null;

 $gottenPageNum = isset($_GET['page']) ? $_GET['page'] : null;

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


if (isset($_GET['catt']) && $qsPos == true || $lstUri != $gottenPageNum) {

		//redirect to 404
	header('Location: ../404');

} else if(in_array($gottenCategory, $categoryArr)) { // if it a valid category


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
<h3 class="category-header">Category: <?php echo ucwords($gottenCategory); ?></h3>

<?php

if ($publishedCatPosts != null) {


$numberOfResults = count($publishedCatPosts);
$numberOfPages = ceil($numberOfResults / $resultsPerPage);


//get the limit starting number for results
$startingLimitNumber = ($gottenPageNum - 1) * $resultsPerPage;

// echo $numberOfPages;
// echo '<br>';
// echo $gottenCategory;

// echo 'gotten page num value is '. $gottenPageNum . '<br>';

if ($gottenPageNum > 0 && $gottenPageNum <= $numberOfPages) {



$limitedPublishedCatPosts = $content->getPublishedCatPostWithLimit($gottenCategory, $startingLimitNumber, $resultsPerPage);


?>


<div class="category-posts">

		<?php


		foreach ($limitedPublishedCatPosts as $publishedCatPost) {
			$timeStamp = $publishedCatPost['created_at'];
		?>

		<div class="single-post">
			<div class="cover-image-wrap">
				<a href="<?php echo '../../contents/' . $publishedCatPost['content_slug']; ?>"><img width="250px" src="<?php echo $uploadDir.$publishedCatPost['content_cover_image']; ?>" alt="<?php echo $publishedCatPost['content_cover_image_alt']; ?>"></a>
			</div>
			<div class="brief-details">
				<h4><a href="<?php echo '../../contents/' . $publishedCatPost['content_slug']; ?>"><?php echo $publishedCatPost['content_title']; ?></a></h4>
				<p><small><i class="fas fa-calendar-alt"></i> <?php echo date('M j, Y', $timeStamp); ?> </small> &nbsp;<small><a href="<?php echo '../../category/'. strtolower($publishedCatPost['content_category']).'/1'; ?>"><i class="fas fa-folder-open"></i> <?php echo $publishedCatPost['content_category']; ?></a></small></p>
			</div>
		</div>

		<?php
		}

?>

</div>

<?php
					//pagination

			//array to store pagination number
			$pagArr = array();

			for ($page = 1; $page <= $numberOfPages; $page++) {

					if($page == $gottenPageNum) {

						array_push($pagArr, '<a href="./'. $page. '" class="active-pag-no">'. $page .'</a> ');

					} else {

						switch ($page) {
							case 1:
							case 2:
							case 3:
							case 4:
							case ($gottenPageNum+1):
							case ($gottenPageNum-1):
							case ($gottenPageNum+2):
							case ($gottenPageNum-2):
							case 10:
							case 20:
							case 30:

								# code...
						array_push($pagArr, ' <a href="./'. $page. '">'. $page .'</a> ');
								break;
								
							default:
							if($pagArr[(count($pagArr)-1)] != '.' || $pagArr[(count($pagArr)-2)] != '.' || $pagArr[(count($pagArr)-3)] != '.'){
								array_push($pagArr, '.');

							}
								# code...
								break;
						}


					}

			}



			?>

		<div class="pagination-wrapper">
			<div>
				
			<?php
			


			echo '<span class="page-num-info">Page '. $gottenPageNum .' of '. $numberOfPages .'</span> ';
			if($gottenPageNum == 1) {
				echo ' <span class="not-allowed-page-num" style="cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></span> ';

			} else {
				echo ' <span><a href="./'. ($gottenPageNum - 1) .'" title="previous"><i class="fas fa-angle-double-left"></i></a></span> ';

			}

			foreach ($pagArr as $arr) {
				echo $arr;
			}

			if($gottenPageNum == $numberOfPages) {
				echo ' <span class="not-allowed-page-num" style="cursor: not-allowed;"><i class="fas fa-angle-double-right"></i></span>';
			} else {
				echo ' <span><a href="./'. ($gottenPageNum + 1) .'" title="next"><i class="fas fa-angle-double-right"></i></a></span>';
			}


			echo ' <span class="last-page-num"><a href="./'. $numberOfPages .'">Last</a></span>';


			?>

			</div>

		</div>

		<?php


	} else {
		header('Location: ../404');		
	}


	} else {
		echo '<p>No content under <b>' . $gottenCategory . '</b> yet.</p>';
	}

		?>

                
<?php 


require_once './inc/extraFooter.php';

require_once './temp/footer.php'; 

} else {

	//redirect to 404
	header('Location: ../404');
}



?>