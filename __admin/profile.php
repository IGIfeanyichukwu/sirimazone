<?php 

session_start();

$stepToRoot = '../../';

require '../classes/Dbase.php';
require '../classes/Login.php';
require '../classes/Content.php';

 $database = new Dbase();
 $db = $database->connect();
 $login = new Login($db);
 $content = new Content($db);

$loggedInUsername = $_SESSION['logged_in_sirimazone_username'];

//getting the request uri of the page
$reqUri = $_SERVER['REQUEST_URI'];

//break the reqUri into parts
$expUri = explode("/", $reqUri);

//get the last part of the URI
$lstUri = $expUri[count($expUri) - 1];
$querysign = '?';
//confirm the existence of a '?' in the last part of the URI
$qsPos = strpos($lstUri, $querysign);

//check if user is logged in
if(isset($_SESSION['is_logged_into_sirimazone'])) {

	$pageTitle = ucwords($loggedInUsername) . '\'s Admin Profile - Sirimazone';

//require header template
require '../temp/header.php';


	//check if the adminuser val is set in the get request
	if(!isset($_GET['adminuser'])){

	//if not, set get request adminuser val 40 logged in username
	header('Location: profile/'.$loggedInUsername);

	} else if (isset($_GET['adminuser']) && $_GET['adminuser'] != $loggedInUsername) {

		//if the link does not have the right logged in username.. redirect
		header('Location: ../../404');
		
	} else if (isset($_GET['adminuser']) && $qsPos == true) {
		//when there's a query sign in the string... redirect
		header('Location: ../404');

	}

	//check if the user just signedup
	if(isset($_SESSION['just_signed_up'])) {

	    	$signupMsg = 'Welcome and Congratulations🎉🎉🎉🎉 Boss '.$_SESSION['logged_in_sirimazone_username'].', You have successfully been registered and signed in as an ADMIN user of Sirimazone. We are happy you joined the wonderful team of individuals that manage Sirimazone contents and we are looking forward to you making Sirimazone better. Thank you.';

	    	echo "<script>
	    		document.querySelector('.modal-bg').classList.add('show-modal-bg');
				mdtoast('". $signupMsg ."', {
					duration: 3000,
		  			type: 'success',
		  			modal: true,
		  			interaction: true, 
		  			actionText: 'OK', 
	  				action: function(){

	    		document.querySelector('.modal-bg').classList.remove('show-modal-bg');
	    
	    			this.hide();
	  			}

				});
			</script>";


			//make the message show just once
			unset($_SESSION['just_signed_up']);


	    } else if(isset($_SESSION['just_signed_in'])) {

	    	//get username
	    	$_siginUsername = $_SESSION['logged_in_sirimazone_username'];

	    	//set signin message
	    	$signinMsg = 'You have been signed in. Welcome back Boss ' . $_siginUsername . '.';

	    	echo "<script>
	    		document.querySelector('.modal-bg').classList.add('show-modal-bg');
				mdtoast('". $signinMsg ."', {
					duration: 3000,
		  			type: 'success',
		  			modal: true,
		  			interaction: true, 
		  			actionText: 'OK', 
	  				action: function(){

	    		document.querySelector('.modal-bg').classList.remove('show-modal-bg');
	    
	    			this.hide();
	  			}

				});
			</script>";

			//make the message show just once
			unset($_SESSION['just_signed_in']);

	    }


// $username = $_SESSION['logged_in_sirimazone_username'];


?>

<div class="profile-header">
	<!-- <div class="profile-header-bg"></div> -->
	<div class="user-img"><i class="fas fa-user"></i></div>
	<h2><?php echo ucfirst($loggedInUsername); ?></h2>
	<p><small><?php echo '@'.$loggedInUsername; ?></small> | <small><?php echo count( $content->getPublishedContentPostBy($loggedInUsername) ); ?> published posts</small> | <small><a style="color: black;" href="../logout">Logout</a></small></p>

	

<p class="other-admins">Other Admins:
	<?php 

	$allAdminStatement = $login->getAllAdminUser();

	while($allAdminUser = $allAdminStatement->fetch(PDO::FETCH_ASSOC)) {
		extract($allAdminUser);
		if($username !== $loggedInUsername) {
		echo ' @'.$username;

	} else if(empty($username)) {
		echo 'none';
	}


	}

	?>
</p>
</div>

<div class="profile-body">
	

	<div class="admin-action-options">
		<ul>
			<!-- <li><a href="#"><i class="fas fa-pencil-alt"></i><br><span>Edit Profile</span></a></li> -->
			<li><a href="../create-content-post"><i class="fas fa-plus"></i><br><span>Create Content Post</span></a></li>
			<li><a href="#"><i class="fas fa-edit"></i><br><span>Manage Content Posts</span></a></li>

			<li><a href="../upload-content"><i class="fas fa-cloud-upload-alt"></i><br><span>Upload Content</span></a></li>

			<li><a href="../delete-content"><i class="fas fa-trash"></i><br><span>Delete Content</span></a></li>
			<li><a href="#"><i class="fas fa-comment-dots"></i><br><span>Manage Post Comments</span></a></li>
			<li><a href="../manage-access-id"><i class="fas fa-user-plus"></i><br><span>Manage Access IDs</span></a></li>
		</ul>
	</div>

</div>











<?php

//include the footer template
require '../temp/footer.php';


} else {  //if the user is not logged in

    
    //go back to authetication
    header('Location: ./');


}

?>