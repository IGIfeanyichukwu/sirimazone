<?php 

session_start();

$stepToRoot = '../../';

require '../classes/Dbase.php';
require '../classes/Login.php';

 $database = new Dbase();
 $db = $database->connect();
 $login = new Login($db);

$loggedInUsername = $_SESSION['logged_in_username'];

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

	    	$signupMsg = 'Welcome and Congratulations🎉🎉🎉🎉 Boss '.$_SESSION['logged_in_username'].', You have successfully been registered and signed in as an ADMIN user of Sirimazone. We are happy you joined the wonderful team of individuals that manage Sirimazone contents and we are looking forward to you making Sirimazone better. Thank you.';

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
	    	$_siginUsername = $_SESSION['logged_in_username'];

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


$user = $_SESSION['logged_in_username'];
echo 'Logged in user is '.$user.'<br>';


?>




<h2>This is the profile page.</h2>
<a href="../logout">Logout</a>








<?php

//include the footer template
require '../temp/footer.php';


} else {  //if the user is not logged in
    
    //go back to authetication
    header('Location: ./');


}

?>