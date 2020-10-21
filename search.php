<?php 
session_start();


require './classes/Dbase.php';
require './classes/Content.php';
require './classes/Login.php';


 $database = new Dbase();
 $db = $database->connect();
 $content = new Content($db);
 $login = new Login($db);

$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';
$gottenPageNum = isset($_GET['page']) ? $_GET['page'] : 1;

$pageTitle = 'You searched for '. $searchQuery .' - Sirimazone';

 $uploadDir = "./uploadz/";

 $resultsPerPage = 3;


require_once './temp/header.php';

//create the LIKE part of the search query
$likeQuery = "";

//get array of keywords from the url
$keywords = explode(' ', $searchQuery);

// var_dump($keywords);
foreach ($keywords as $keyword) {
	$likeQuery .= "content_title LIKE '%". $keyword ."%' OR ";
}

//remove extra unneccessary string
$likeQuery = substr($likeQuery, 0, (strlen($likeQuery) - 4));

$returnedQueryArr = $content->getPostBySearchQuery($likeQuery);

?>
<h2>Search Results for - "<?php echo $searchQuery; ?>"</h2>
<p><i><?php echo 'Results found: '. count($returnedQueryArr); ?></i></p>

	
	<?php
	if ($returnedQueryArr != null) {
		//get total number of results
		$numberOfResults = count($returnedQueryArr);

		//calc the number of pages from the results
		$numberOfPages = ceil($numberOfResults / $resultsPerPage);

		//get the limit starting number for results
		$startingLimitNumber = ($gottenPageNum - 1) * $resultsPerPage;


if ($gottenPageNum > 0 && $gottenPageNum <= $numberOfPages) {

	$resultQuantity = $numberOfResults == 1 ? 'result' : 'results';


		echo "<script>

			mdtoast('whoopee🕺💃, ". $numberOfResults ." ". $resultQuantity ." found', {
				duration: 4000,
	  			type: 'info'
			});
		</script>";

?>

<div class="search-results">

<?php


		$limitedReturnedQueryArr = $content->getPostBySearchQueryWithLimit($likeQuery, $startingLimitNumber, $resultsPerPage);


		// echo count($limitedReturnedQueryArr);
		// var_dump($limitedReturnedQueryArr);

		foreach ($limitedReturnedQueryArr as $returnedResult) {
					$postTimestamp = $returnedResult['created_at'];
				?>

				<div>
					<div class="cover-image-wrap">
						<a href="<?php echo './contents/' . $returnedResult['content_slug']; ?>"><img width="250px" src="<?php echo $uploadDir.$returnedResult['content_cover_image']; ?>" alt=""></a>
					</div>
					<div class="brief-details">
						<h4><a href="<?php echo './contents/' . $returnedResult['content_slug']; ?>"><?php echo $returnedResult['content_title']; ?></a></h4>
						<p><small><i class="fas fa-calendar-alt"></i><?php echo date('F j, Y', $postTimestamp); ?> </small> <small><a href="<?php echo './category/'. strtolower($returnedResult['content_category']).'/1'; ?>"><i class="fas fa-folder-open"></i><?php echo $returnedResult['content_category']; ?></a></small></p>
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

						array_push($pagArr, '<a href="./search?query='. $searchQuery.'&page='. $page. '" style="background: green;" class="active-pag-no">'. $page .'</a> ');

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
						array_push($pagArr, ' <a href="./search?query='. $searchQuery.'&page='. $page. '">'. $page .'</a> ');
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
				
			<?php
			


			echo '<span>Page '. $gottenPageNum .' of '. $numberOfPages .'</span> ';
			if($gottenPageNum == 1) {
				echo ' <span style="cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></span> ';

			} else {
				echo ' <span><a href="./search?query='. $searchQuery.'&page='. ($gottenPageNum - 1) .'" title="previous"><i class="fas fa-angle-double-left"></i></a></span> ';

			}

			foreach ($pagArr as $arr) {
				echo $arr;
			}

			if($gottenPageNum == $numberOfPages) {
				echo ' <span style="cursor: not-allowed;"><i class="fas fa-angle-double-right"></i></span>';
			} else {
				echo ' <span><a href="./search?query='. $searchQuery.'&page='. ($gottenPageNum + 1) .'" title="next"><i class="fas fa-angle-double-right"></i></a></span>';
			}


			echo ' <span><a href="./search?query='. $searchQuery.'&page='. $numberOfPages .'">last</a></span>';


			?>

		</div>


<?php

} else {
	//redirect to not found page
	header('Location: ./404');

}

	} else {
		// echo 'no results found'
		echo "<script>

			mdtoast('oops😢, no result found', {
				duration: 4000,
	  			type: 'info'
			});
		</script>";

		?>
		<p>Sorry, no result found</p>

		<?php
	}


	 ?>





<?php



require_once './temp/footer.php';


?>