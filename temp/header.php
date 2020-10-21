<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo isset($pageTitle) ? $pageTitle : null; ?></title>
    <link rel="stylesheet" href="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'styles/css/mdtoast.css'; ?>">

    <link rel="stylesheet" href="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'styles/css/style.css'; echo '?v='.time() ?>">

	<script src="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'scripts/prod/mdtoast.min.js'; ?>"></script>
	
 <?php 
 		if(isset($usejQuery) && $usejQuery === true) {
 	?>
	<script src="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'scripts/prod/jquery-3.3.1.js'; ?>"></script>
 	<?php
 		}

 		if(isset($useAjaxUpload) && $useAjaxUpload === true) {
 	?>

	<script src="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'scripts/prod/ajaxupload.js'; ?>"></script>

	<?php
 		}

$searchPage = 'search';
 ?>


</head>
<body>
<div class="modal-bg"></div>
<div class="container">
    <header class="header">
	<h2>Sirima<span>zone</span></h2>
	<form action="<?php echo isset($stepToRoot) ? $stepToRoot . $searchPage : './'. $searchPage; ?>" method="get">
	    <input type="search" name="query" id="main-search" placeholder="Search here" class="header-search">
	    <button><i class="fas fa-search"></i></button>
	</form>
	
	<nav class="nav">
        <ul>
            <li><a href="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo ''; ?>" class="<?php echo isset($activateHome) ? 'activate-home' : null; ?>"><i class="fas fa-home"></i> Home</a></li>
            <!-- <li><a href="#" class="<?php //echo isset($activateFeed) ? 'activate-feed' : null; ?>"><i class="fas fa-comment-alt"></i> Feedback</a></li> -->
            <li><a href="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'category/hollywood/1'; ?>" class="<?php echo isset($activateHolly) ? 'activate-holly' : null; ?>"><i class="fas fa-fire"></i><span></span>Hollywood</a></li>
            <li><a href="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'category/nollywood/1'; ?>" class="<?php echo isset($activateNolly) ? 'activate-nolly' : null; ?>"><i class="fas fa-fire"></i><span></span>Nollywood</a></li>
            <li><a href="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'category/bollywood/1'; ?>" class="<?php echo isset($activateBolly) ? 'activate-bolly' : null; ?>"><i class="fas fa-fire"></i><span></span>Bollywood</a></li>
            <li><a href="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'category/others/1'; ?>" class="<?php echo isset($activateOthers) ? 'activate-others' : null; ?>"><i class="fas fa-fire"></i><span></span>Others</a></li>
        </ul>
	</nav>
	
	<div class="random-movie-container">
	    <h3>Random Movies</h3>
	    <div class="random-movie-wrap">
    	<?php 
    	if (isset($content)) { 

    		$pubPostArrStatement = $content->getPublishedContentPost();

    		$pubPostArr = $pubPostArrStatement->fetchAll();

    		if ($pubPostArr != null) {

    		//get max value of random number
    		$randMax = count($pubPostArr) - 1;

    		// echo $randMax;

    		//set random values
    		$rand1 = rand(0, $randMax);
    		$rand2 = rand(0, $randMax);
    		$rand3 = rand(0, $randMax);
    		$rand4 = rand(0, $randMax);


	    ?>
	        <ul>
	            <li><a href="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'contents/' . $pubPostArr[$rand1]['content_slug']; ?>"><?php echo $pubPostArr[$rand1]['content_title']; ?></a></li>
	            <li><a href="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'contents/' . $pubPostArr[$rand2]['content_slug']; ?>"><?php echo $pubPostArr[$rand2]['content_title']; ?></a></li>
	            <li><a href="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'contents/' . $pubPostArr[$rand3]['content_slug']; ?>"><?php echo $pubPostArr[$rand3]['content_title']; ?></a></li>
	            <li><a href="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'contents/' . $pubPostArr[$rand4]['content_slug']; ?>"><?php echo $pubPostArr[$rand4]['content_title']; ?></a></li>
	        </ul>

        <?php 
		    } else {

		    	echo '<p class="no-content"><small>No content yet.</small></p>';
		    }

	    } else { echo 'content var not set'; } 

        ?>
	    </div>
	    
	    
	</div>
<?php if(isset($_SESSION['logged_in_sirimazone_username'])) { ?>
	<div class="login-icon-wrap">
       <div><span><i class="fas fa-user"></i></span></div> 
       <div><span><?php echo '@'; echo $_SESSION['logged_in_sirimazone_username']; ?></span></div>
	</div>
<?php } ?>
	
	</header>
	<div class="main">
            <div class="main-display">