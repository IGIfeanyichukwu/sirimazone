<?php 
session_start();

$pageTitle = 'Sirimazone | Home of Movie Downloads and Entertainment';

$activateHome = true;

require './classes/Dbase.php';
require './classes/Content.php';

 $database = new Dbase();
 $db = $database->connect();
 $content = new Content($db);


 $publishedPostsStatement = $content->getPublishedContentPost();

 $publishedPosts = $publishedPostsStatement->fetchAll();

 $resultsPerPage = 18;

$limitedPublishedPosts = $content->getPublishedContentPostWithLimit(0, $resultsPerPage);

//get array of pinned post
$pinnedPublishedPosts = $content->getPinnedPublishedContentPost();


 $uploadDir = "./uploadz/";

require_once './temp/header.php'; 

// print_r($publishedPosts);

?>
	
			<?php

			// var_dump($pinnedPublishedPosts);
			if ($pinnedPublishedPosts != null) {

				?>

	<div class="all-pinned-posts">
		<h3 class="all-pinned-posts-header">📌 Pinned Posts</h3>
		<div class="pinned-posts">

				<?php

				foreach ($pinnedPublishedPosts as $pinnedPublishedPost) {
					$pinnedPublishedPostTime = $pinnedPublishedPost['created_at'];
				?>

				<div class="single-post">
					<div class="cover-image-wrap">
						<a href="<?php echo './contents/' . $pinnedPublishedPost['content_slug']; ?>"><img width="250px" src="<?php echo $uploadDir.$pinnedPublishedPost['content_cover_image']; ?>" alt="<?php echo $pinnedPublishedPost['content_cover_image_alt']; ?>"></a>
					</div>
					<div class="brief-details">
						<h4><a href="<?php echo './contents/' . $pinnedPublishedPost['content_slug']; ?>"><?php echo $pinnedPublishedPost['content_title']; ?></a></h4>
						<p><small><i class="fas fa-calendar-alt"></i><?php echo date('F j, Y', $pinnedPublishedPostTime); ?> </small> &nbsp;<small><a href="<?php echo './category/'. strtolower($pinnedPublishedPost['content_category']).'/1'; ?>"><i class="fas fa-folder-open"></i><?php echo $pinnedPublishedPost['content_category']; ?></a></small></p>
					</div>
				</div>

				<?php
				}
				?>

		</div>
	</div>

<?php

			}

			 ?>


	<h3 class="all-contents-post-header">All Content Posts</h3>

		<?php

		if($publishedPosts != null) {


		$numberOfResults = count($publishedPosts);

		$numberOfPages = ceil($numberOfResults / $resultsPerPage);
		?>

	<div class="all-posts">

		<?php

		foreach ($limitedPublishedPosts as $publishedPost) {
			$timeStamp = $publishedPost['created_at'];
		?>

		<div class="single-post">
			<div class="cover-image-wrap">
				<a href="<?php echo './contents/' . $publishedPost['content_slug']; ?>"><img width="250px" src="<?php echo $uploadDir.$publishedPost['content_cover_image']; ?>" alt="<?php echo $publishedPost['content_cover_image_alt']; ?>"></a>
			</div>
			<div class="brief-details">
				<h4><a href="<?php echo './contents/' . $publishedPost['content_slug']; ?>"><?php echo $publishedPost['content_title']; ?></a></h4>
				<p><small><i class="fas fa-calendar-alt"></i> <?php echo date('M j, Y', $timeStamp); ?> </small> &nbsp;<small><a href="<?php echo './category/'. strtolower($publishedPost['content_category']).'/1'; ?>"><i class="fas fa-folder-open"></i> <?php echo $publishedPost['content_category']; ?></a></small></p>
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

			if($page == 1) {
				array_push($pagArr, '<a href="./" class="active-pag-no">'. $page .'</a> ');
			}else {


					switch ($page) {
						case 2:
						case 3:
						case 4:
						case 10:
						case 20:
						case 30:

							# code...
					array_push($pagArr, '<a href="./page/'. $page. '">'. $page .'</a> ');
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

			echo '<span class="page-num-info">Page 1 of '. $numberOfPages .'</span> ';
			echo ' <span class="not-allowed-page-num" style="cursor: not-allowed"><i class="fas fa-angle-double-left"></i></span> ';


			foreach ($pagArr as $arr) {
				echo $arr;
			}

			if($numberOfPages != 1) {
				echo ' <span><a href="./page/2" title="next"><i class="fas fa-angle-double-right"></i></a></span>';
			} else {
				echo ' <span class="not-allowed-page-num" style="cursor: not-allowed"><i class="fas fa-angle-double-right"></i></span>';
			}



			echo ' <span class="last-page-num"><a href="./page/'. $numberOfPages .'">Last</a></span>';





		?>
		</div>

		</div>

		<?php



	} else {
		echo '<p>No content yet.</p>';
	}

		?>
                
<?php 

require_once './inc/extraFooter.php';

require_once './temp/footer.php'; 

?>