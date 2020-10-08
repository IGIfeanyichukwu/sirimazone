<?php 

session_start();

$stepToRoot = '../';

require '../classes/Dbase.php';
require '../classes/Login.php';

 $database = new Dbase();
 $db = $database->connect();
 $login = new Login($db);



$username = 'null';

if(isset($_GET['adminuser'])){
	$username = $_GET['adminuser'];

}


// echo "<br>Username is ".$username;


if(isset($_SESSION['is_logged_into_sirimazone'])) {

require_once '../temp/header.php';

	if(!isset($_GET['adminuser'])){
	$loggedInUsername = $_SESSION['logged_in_username'];

	header('Location: profile/'.$loggedInUsername);

	}


	if(isset($_SESSION['just_signed_up'])) {
	    	$signupMsg = 'Welcome🎉🎉 Boss '.$_SESSION['logged_in_username'].', You have successfully been registered as an ADMIN user of Sirimazone. We are happy you joined the wonderful team of individuals that manage Sirimazone contents and we are looking forward to you making Sirimazone better. Thank you.';

	    	/*echo "<script>

				mdtoast('". $signupMsg ."', {
					duration: 3000,
		  			type: 'success',
		  			modal: true,
		  			interaction: true, 
		  			actionText: 'Close', 
	  				action: function(){
	    
	    			this.hide();
	  			}

				});
			</script>";
*/
			// unset($_SESSION['just_signed_up']);


	    } else {

	    	echo "<br>just_signed_up is not set <br>";
	    }

$user = $_SESSION['logged_in_username'];
echo 'Logged in user is '.$user.'<br>';


?>

<h2>This is the profile page.</h2>
<a href="../logout">Logout</a>



<?php

require_once '../temp/footer.php';



} else {  //if the user is not logged in
    
    //go back to authetication
    header('Location: ./');    
}



?>