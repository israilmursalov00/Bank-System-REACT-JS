<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

	if (Session::isHave("USER_LOGIN")) {
		go("home",0.1);
	} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Bank Index</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	.container {
	    padding: 50px;
		background-color: #eee;
		border-radius: 20px;

	}


	.tercih {
		flex: 1;
		margin-left: 20px;
		text-align: center;
		align-self: center;
		padding: 10px;
		border-radius: 10px;
		background-color: #ccc;
		cursor: pointer;
	}

	.input-container {
		display: flex;
	}

	.login {
		width: 20%;

	}

	.system {
		display: flex;
	}

	img {
		width: 70px;
	}

	a {
		color: unset;
		text-decoration: auto;
	}

	</style>
</head>
<body>
	<div class="container">
		 <form action="javascript:void(0);" method="post" id="form">
		<div class="system">
					<div class="tercih login">
						<a href="login">
							<div class="">
								<img src="https://cdn-icons-png.flaticon.com/512/5087/5087579.png"/>
								<h1>Login</h1>
							</div>
						</a>
		    		</div>
					<div class="tercih login">
						<a href="register">
							<div>
								<img src="https://cdn-icons-png.flaticon.com/512/5087/5087579.png"/>
								<h1>Register</h1>
							</div>
						</a>
		    		</div>	
		    </div>			
		 </form>
	</div>
</body>
</html>

<?php

echo sha1(md5(rand(5, 20)));
	}

?>
