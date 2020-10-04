<?php 
session_start();

$stepToRoot = '../';



require_once '../temp/header.php';
if(isset($_SESSION['is_logged_into_sirimazone'])) {
    //display index page if the user is logged in

echo '<h2>This is the admin page</h2>';


} else {
    echo '<h2>You need to login in</h2>';
}

require_once '../temp/footer.php';