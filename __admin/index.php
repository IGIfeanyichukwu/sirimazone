<?php 
session_start();

$stepToRoot = '../';

require '../classes/Dbase.php';
require '../classes/Login.php';

 $database = new Dbase();
 $db = $database->connect();
 $login = new Login($db);

require_once '../temp/header.php';


//check if the user is logged in
if(isset($_SESSION['is_logged_into_sirimazone'])) {

	//get username
	$loggedInUsername = $_SESSION['logged_in_username'];

	//redirect to profile page
	header('Location: profile/'.$loggedInUsername);

} else {
    
    require_once('inc/adminAccessAuth.php');
    
}

require_once '../temp/footer.php';

?>