function validateEmail(emailClass) {

	const emailInput = document.querySelector(`.${emailClass}`).value;

	const atPosition = emailInput.indexOf('@');
	const dotPosition = emailInput.lastIndexOf(".");

	if(atPosition < 1 || dotPosition < atPosition+2 || dotPosition+2 >= emailInput.length) {

		mdtoast('The Email o wrong nau', {
			duration: 2000,
			type: 'error' 
		});


		return false;
	}


}