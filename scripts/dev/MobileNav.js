const MobileNav = () => {

	const menuBtn = document.querySelector('.menu-btn');
	const menuBtnIcon = document.querySelector('.menu-btn i');
	const menuNavBg = document.querySelector('.menu-nav-bg');
	const header = document.querySelector('.header');

	menuBtn.addEventListener('click', function(e) {
		if(header.classList.contains('open-mobile-nav')) {
			header.classList.remove('open-mobile-nav');
			menuBtnIcon.classList.remove('fa-times');
			menuBtnIcon.classList.add('fa-bars');
			menuNavBg.classList.remove('show-modal-bg');
			console.log('nav closed');
		} else {
			header.classList.add('open-mobile-nav');
			menuBtnIcon.classList.add('fa-times');
			menuBtnIcon.classList.remove('fa-bars');
			menuNavBg.classList.add('show-modal-bg');
			console.log('nav opened');
		}
	});

	console.log(menuBtnIcon);



}


export default MobileNav;