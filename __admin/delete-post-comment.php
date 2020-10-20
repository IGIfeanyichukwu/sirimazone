<?php 
session_start();

$stepToRoot = '../';

$pageTitle = 'Delete Post Comment - Sirimazone';

require '../classes/Dbase.php';
require '../classes/Content.php';
require '../classes/Login.php';

 $database = new Dbase();
 $db = $database->connect();
 $content = new Content($db);
 $login = new Login($db);


//check if the user is logged in
if(isset($_SESSION['is_logged_into_sirimazone'])) {


require_once '../temp/header.php';

	//get username
	$loggedInUsername = $_SESSION['logged_in_sirimazone_username'];

?>

<h2 class="page-title"><span><a href="<?php echo './profile/'.$loggedInUsername; ?>"><i class="fas fa-arrow-left"></i></a></span> Delete Post Comment</h2>

<p>You can delete post comment here.</p>

<div class="alert-role-box">
	<b>NB:</b> You can only delete comments under your posts.
</div>


<?php

require_once '../temp/footer.php';


} else {  //if the user is not logged in
    
    //go back to authetication
    header('Location: ./');


}


?>