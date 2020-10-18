<?php 

// Get all the inputs
$accessName = trim($login->escapeString($_POST['access-name']));
$accessKey = trim($login->escapeString($_POST['access-key']));

if (empty($accessName) || empty($accessKey)) {
	echo "<script>

		mdtoast('All fields are required', {
			duration: 3000,
  			type: 'error'
		});
	</script>";

} else if($login->checkForDuplicateAccessName($accessName) != null) {
	echo "<script>

		mdtoast('Access ID with this name exists', {
			duration: 4000,
  			type: 'error'
		});
	</script>";

} else {

	//insert into db
	if($login->createAccessID($accessName, $accessKey, $loggedInUsername)) {
		echo "<script>
	    		document.querySelector('.modal-bg').classList.add('show-modal-bg');
				mdtoast('Access ID has been successfully created.', {
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
	}

}