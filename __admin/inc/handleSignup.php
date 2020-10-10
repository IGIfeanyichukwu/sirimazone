<?php 

// Get all the inputs
$signupUsername = trim($login->escapeString($_POST['signup-username']));
$signupEmail = trim($login->escapeString($_POST['signup-email']));
$signupPassword1 = trim($login->escapeString($_POST['signup-password1']));
$signupPassword2 = trim($login->escapeString($_POST['signup-password2']));
$signupAccessName = trim($login->escapeString($_POST['signup-accessname']));
$signupAccessKey = trim($login->escapeString($_POST['signup-accesskey']));


if($signupPassword1 != $signupPassword2) {

	echo "<script>

		mdtoast('Different Passwords', {
			duration: 3000,
  			type: 'error'
		});
	</script>";

} else if(preg_match("/\W/", $signupUsername)) {

	echo "<script>

		mdtoast('Username can only contain letter, number or underscore values', {
			duration: 3000,
  			type: 'error'
		});
	</script>";

} else {

	$result = $login->getAccessId($signupAccessName);

    $gottenAccessId = $result->fetch(PDO::FETCH_OBJ);

    // print_r($gottenAccessId);


    //check if an access id was found in the db based on the given access name
    if($gottenAccessId != null) {//if access id is found based on the access name

    	//check if access key is the same
       if (password_verify($signupAccessKey, $gottenAccessId->access_key)) {//if true

       		//CHECK FOR VALIDITY OF ACCESS ID
       		if($gottenAccessId->is_used) {//if used.... not valid

       			echo "<script>
						mdtoast('Access ID is no longer valid', {
							duration: 4000,
				  			type: 'error'
						});
				</script>";

       		} else { //if not used... valid
       		

	       		//check if username exist
	       		$gottenExistingUsername = $login->checkIfUsernameExists($signupUsername);

	       		//check if email exist
	       		$gottenExistingEmail = $login->checkIfEmailExists($signupEmail);


	       		if($gottenExistingUsername != null && $gottenExistingEmail == null) {

	       			echo "<script>
							mdtoast('Username has been used', {
								duration: 4000,
					  			type: 'error'
							});
					</script>";

	       		} else if ($gottenExistingEmail != null && $gottenExistingUsername == null) {

	       			echo "<script>
							mdtoast('Email has been used', {
								duration: 4000,
					  			type: 'error'
							});
					</script>";

	       		} else if ($gottenExistingUsername != null && $gottenExistingEmail != null) {

	       			echo "<script>
							mdtoast('Username and Email have been used', {
								duration: 4000,
					  			type: 'error'
							});
					</script>";

	       		} else {//username and email are new


	       			//REGISTER USER AS AN ADMIN
	       			if($login->addAdminUser($signupUsername, $signupEmail, $signupPassword1)) {

	       				if($login->updateAccessIdUsedStatus($signupAccessName)) {
	       					echo "<br> Access ID status was changed <br>";
	       				}

						$_SESSION['is_logged_into_sirimazone'] = true;
	                    $_SESSION['logged_in_sirimazone_username'] = $signupUsername;
	            		$_SESSION['just_signed_up'] = true;

	            		//redirect to profile page
						header('Location: profile/'.$signupUsername);
            		
            		exit();	       				


	       			} else {

	       				//the user could not be registered
	       				echo "<script>
							mdtoast('Something went wrong. You could not be registered.', {
								duration: 4000,
					  			type: 'error'
							});
						</script>";


	       			}





	       		}

       		}


       } else {
       		echo "<script>
				mdtoast('Incorrect Access Key', {
					duration: 3000,
		  			type: 'error'
				});
			</script>";
       }

    } else {
    	echo "<script>

			mdtoast('Incorrect Access Name', {
				duration: 3000,
	  			type: 'error'
			});
		</script>";
    }


}
