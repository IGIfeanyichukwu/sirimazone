<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sirimazone Site</title>
    <link rel="stylesheet" href="<?php echo isset($stepToRoot) ? $stepToRoot : null; echo 'styles/css/style.css'; ?>">
</head>
<body>
<div class="container">
    <header class="header">
	<h2>Sirima<span>zone</span></h2>
	<form action="">
	    <input type="search" name="search" id="main-search" placeholder="Search here" class="header-search">
	    <button><i class="fas fa-search"></i></button>
	</form>
	
	<nav class="nav">
        <ul>
            <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#"><i class="fas fa-comment-alt"></i> Feedback</a></li>
            <li><a href="#"><i class="fas fa-fire"></i><span></span>Hollywood</a></li>
            <li><a href="#"><i class="fas fa-fire"></i><span></span>Nollywood</a></li>
            <li><a href="#"><i class="fas fa-fire"></i><span></span>Bollywood</a></li>
            <li><a href="#"><i class="fas fa-fire"></i><span></span>Others</a></li>
        </ul>
	</nav>
	
	<div class="random-movie-container">
	    <h3>Random Movies</h3>
	    <div class="random-movie-wrap">
	        <ul>
	            <li><a href="#">Movie One</a></li>
	            <li><a href="#">Movie Two</a></li>
	            <li><a href="#">Movie Three</a></li>
	            <li><a href="#">Movie Four</a></li>
	        </ul>
	    </div>
	    
	    
	</div>
	
	<div class="login-icon-wrap">
       <div><span><i class="fas fa-user"></i></span></div> 
       <div><span>Guest</span></div>
	</div>
	
	</header>
	<div class="main">
            <div class="main-display">