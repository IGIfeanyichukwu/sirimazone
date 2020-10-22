<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Error 404 - Page Not Found</title>
	<link rel="stylesheet" href="">

	<style type="text/css">
		* {
			padding: 0;
			margin: 0;
			box-sizing: border-box;
		}

		html {
			font-size: 62.5%;
		}

		body {
			font-size: 1.6rem;
		}

		::selection {
			background: transparent;
		}

		.container {
			/*background: orange;*/
			width: 100%;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.wrapper {
			text-align: center;
		}

		.wrapper h1 {
			font-size: 25rem;
			color: rgba(34, 37, 70);
			z-index: 1;
			font-family: serif;
		}

		.wrapper h1 span {
			color: rgba(252, 105, 23);
			display: inline-block;
			transform: rotate3d(2, -1, -1, -0.2turn);
			animation: swingy 3s ease-in-out 0s infinite alternate;
		}

		.wrapper p {
			font-size: 2rem;
			font-family: sans-serif;
			transform: translateY(-3rem);

		}

		.wrapper a {
			background: rgba(252, 105, 23);
			text-decoration: none;
			padding: 0.8rem 1rem;
			font-family: sans-serif;
			border-radius: 0.3rem;
			font-weight: bold;
			color: rgba(34, 37, 70);
			box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
		}

		.wrapper a:hover {
			background: rgba(34, 37, 70);
			color: white;

		}

		@media screen and (max-width: 425px) {

			.wrapper h1 {
				font-size: 20rem;
			}
			
		}

		@media screen and (max-width: 340px) {

			.wrapper h1 {
				font-size: 15rem;
			}
			
		}

		@media screen and (max-width: 340px) {

			.wrapper h1 {
				font-size: 10rem;
			}
			
		}

		@keyframes swingy {

			from {
				transform: rotate(-23deg);
				opacity: 1;
			}

			to {
				transform: rotate(23deg);
				opacity: 0.1;
			}
			
		}

		
	</style>
</head>
<body>

	<div class="container">

		<div class="wrapper">
			<h1>4<span>0</span>4</h1>

			<p>Page Not Found</p>

			<a href="./">GO HOME</a>
		</div>
		
	</div>
	
</body>
</html>

