<?php 
session_start();

$stepToRoot = '../';



require_once '../temp/header.php';
if(isset($_SESSION['is_logged_into_sirimazone'])) {
    //display index page if the user is logged in

echo '<h2>This is the admin page</h2>';


} else {
    
    require_once('inc/login.php');
    
}

require_once '../temp/footer.php';