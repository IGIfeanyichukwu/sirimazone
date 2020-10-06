
const adminAccess = () => {

// console.log('From adminlogin.js');

const  openSignup = document.querySelector('.open-signup');
const  openSignin = document.querySelector('.open-signin');
const signupForm = document.querySelector('.signup-form');
const signinForm = document.querySelector('.signin-form');


openSignup.onclick = function () {
	signupForm.classList.remove('display-none');
	signinForm.classList.add('display-none');
}


openSignin.onclick = function () {
	signinForm.classList.remove('display-none');
	signupForm.classList.add('display-none');
}


}


export default adminAccess;