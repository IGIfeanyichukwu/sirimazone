
const AdminAccess = () => {

// console.log('From adminlogin.js');

const  openSignup = document.querySelector('.open-signup');
const  openSignin = document.querySelector('.open-signin');
const signupForm = document.querySelector('.signup-form');
const signinForm = document.querySelector('.signin-form');

if (openSignup !== null && signupForm !== null) {
openSignup.onclick = function () {
	signupForm.classList.remove('display-none');
	signinForm.classList.add('display-none');
}
} else {
	// console.log('opensignup and signupForm are null');
}


if(openSignin !==null && signinForm !== null) {

openSignin.onclick = function () {
	signinForm.classList.remove('display-none');
	signupForm.classList.add('display-none');
}

} else {
	// console.log('openSignin and signinForm are both null');
}

}


export default AdminAccess;