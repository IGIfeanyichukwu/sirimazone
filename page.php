<?php 
session_start();


$stepToRoot = '../';
$pageTitle = 'Sirimazone | Home of Movie Downloads and Entertainment';

require './classes/Dbase.php';
require './classes/Content.php';

 $database = new Dbase();
 $db = $database->connect();
 $content = new Content($db);


 $publishedPostsStatement = $content->getPublishedContentPost();

 $publishedPosts = $publishedPostsStatement->fetchAll();

 $resultsPerPage = 6;

 $uploadDir = "../uploadz/";

require_once './temp/header.php'; 

// print_r($publishedPosts);

?>

	<div class="all-posts">

		<?php

		if($publishedPosts != null) {

			//get the current number for get method
			$gottenPageNum = $_GET['page'];

			$numberOfResults = count($publishedPosts);

			$numberOfPages = ceil($numberOfResults / $resultsPerPage);

			//get the limit starting number for results
			$startingLimitNumber = ($gottenPageNum - 1) * $resultsPerPage;

			if ($gottenPageNum > 0 && $gottenPageNum <= $numberOfPages) {

			if ($gottenPageNum == 1) {
				header('Location: ../');

			}

			$limitedPublishedPosts = $content->getPublishedContentPostWithLimit($startingLimitNumber, $resultsPerPage);



			foreach ($limitedPublishedPosts as $publishedPost) {
				$timeStamp = $publishedPost['created_at'];
			?>

			<div>
				<div class="cover-image-wrap">
					<img width="250px" src="<?php echo $uploadDir.$publishedPost['content_cover_image']; ?>" alt="">
				</div>
				<div class="brief-details">
					<h4><a href="<?php echo './contents/' . $publishedPost['content_slug']; ?>"><?php echo $publishedPost['content_title']; ?></a></h4>
					<p><small><i class="fas fa-calendar-alt"></i> <?php echo date('F j, Y', $timeStamp); ?> </small> <small><a href="<?php echo './category/'. $publishedPost['content_category']; ?>"><i class="fas fa-folder-open"></i> <?php echo $publishedPost['content_category']; ?></a></small></p>
				</div>
			</div>

			<?php

			} 

			//pagination

			//array to store pagination number
			$pagArr = array();

			for ($page = 1; $page <= $numberOfPages; $page++) {

				if($page == 1) {
					array_push($pagArr, '<a href="../">'. $page .'</a> ');
				}else {

					if($page == $gottenPageNum) {

						array_push($pagArr, '<a href="./'. $page. '" style="background: green;" class="active-pag-no">'. $page .'</a> ');

					} else {

						switch ($page) {
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
			}



			?>

		<div class="pagination-wrapper">
				
			<?php
			


			echo '<span>Page '. $gottenPageNum .' of '. $numberOfPages .'</span> ';
			if($gottenPageNum == 2) {
				echo ' <span><a href="../" title="previous"><i class="fas fa-angle-double-left"></i></a></span> ';

			} else {
				echo ' <span><a href="./'. ($gottenPageNum - 1) .'" title="previous"><i class="fas fa-angle-double-left"></i></a></span> ';

			}

			foreach ($pagArr as $arr) {
				echo $arr;
			}

			if($gottenPageNum == $numberOfPages) {
				echo ' <span style="cursor: not-allowed;"><i class="fas fa-angle-double-right"></i></span>';
			} else {
				echo ' <span><a href="./'. ($gottenPageNum + 1) .'" title="next"><i class="fas fa-angle-double-right"></i></a></span>';
			}


			echo ' <span><a href="./'. $numberOfPages .'">last</a></span>';


			?>

		</div>

			<?php


			} else {
				header('Location: ../404');
			}

	} else {
		echo '<p>No content yet.</p>';
	}

		?>
	</div>
                
<?php 

require_once './inc/extraFooter.php';

require_once './temp/footer.php'; 

?>