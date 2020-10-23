<?php 
session_start();

$stepToRoot = '../';

$pageTitle = 'Manage Access ID - Sirimazone';

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

if (isset($_POST['accessid-submit-btn'])) {
	require_once './inc/handleAccessIDCreation.php';
}

if (isset($_POST['clear-all-btn'])) {

	if($login->deleteAllAccessIDs()) {
		echo "<script>
	    		document.querySelector('.modal-bg').classList.add('show-modal-bg');
				mdtoast('All Access IDs deleted successfully.', {
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
	} else {
		echo "<script>

		mdtoast('Access IDs could not be deleted. Try again.', {
			duration: 3000,
  			type: 'error'
		});
	</script>";
	}
}

$numOfIDs = $login->getAvailableAccessIdNum(1);
$numOfUnusedIDs = $login->getAvailableAccessIdNum(2);
?>

<h3 class="page-title"><span><a href="<?php echo './profile/'.$loggedInUsername; ?>"><i class="fas fa-arrow-left"></i></a></span> Manage Access ID</h3>

<p>A user needs an Access ID to be registered as an <b>ADMIN</b>. Only <b>existing</b> admins can create <b>ACCESS IDs</b> for others to register and become admins. An access id consist of ACCESS NAME and ACCESS KEY.</p>

<div class="alert-role-box">
	<b>NB:</b> A new admin has all right to sirimazone's management as any other existing admin. Please, create  ACCESS ID for only trusted users.
</div>

<div class="create-access-id-div">
	<form method="post" action="">
		<div>
			<label for="access-name">Enter Access Name</label>
			<input type="text" name="access-name" id="access-name" required>
		</div>

		<div>
			<label for="access-key">Enter Access Key</label>
			<input type="text" name="access-key" id="access-key" required>
		</div>

		<div>
			<button type="submit" id="accessid-submit-btn" name="accessid-submit-btn">Create ID</button>
		</div>
	</form>
</div>

<div class="available-access-id">
	<p>Number of available Access IDs is <b><?php echo $numOfIDs; ?></b>. Number of unused Access IDs is <b><?php echo $numOfUnusedIDs; ?></b></p>
	<p>For security reasons, all Access IDs should be cleared from time to time.</p>

	<form action="" method="post">
		<button type="submit" name="clear-all-btn" id="clear-all-btn"><i class="fas fa-times"></i> CLEAR ALL ACCESS ID</button>
	</form>
</div>


<?php

require_once '../temp/footer.php';


} else {  //if the user is not logged in
    
    //go back to authetication
    header('Location: ./');


}


?>