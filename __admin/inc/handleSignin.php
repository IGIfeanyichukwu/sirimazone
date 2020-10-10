<?php 

// Get all the inputs
$signinUsername = trim($login->escapeString($_POST['signin-username']));
$signinPassword = trim($login->escapeString($_POST['signin-password']));

if (empty($signinUsername) || empty($signinPassword)) {
	echo "<script>

		mdtoast('All fields are required', {
			duration: 3000,
  			type: 'error'
		});
	</script>";

} else {
	//get user with entered username
    $returnedStatement = $login->getAdminUser($signinUsername);

    //store the gotten user with all the
    $gottenUser = $returnedStatement->fetch(PDO::FETCH_OBJ);

    if($gottenUser != null) {
    	if (password_verify($signinPassword, $gottenUser->password)) {
    		$_SESSION['is_logged_into_sirimazone'] = true;
            $_SESSION['logged_in_sirimazone_username'] = $signinUsername;
    		$_SESSION['just_signed_in'] = true;

    		//redirect to profile page
			header('Location: profile/'.$signinUsername);
    		exit();
    	} else {
    		//user entered false
   			echo "<script>

				mdtoast('Incorrect details👿', {
					duration: 3000,
		  			type: 'error'
				});
			</script>";
    	}
    } else {
    	//user entered false still
   			echo "<script>

				mdtoast('Incorrect details👿', {
					duration: 3000,
		  			type: 'error'
				});
			</script>";
      
	}
}


