<?php
	
	require_once "script/php_script.php";

	if (Session::isHave("USER_LOGIN")) {
	
		go("home",0.1); 
	
	} else {
		
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | Bank</title>
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<style type="text/css">

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
		.col-input {
			padding: 10px;
			display: flex;
			flex-direction: column;
		}

		input {
			width: 50%;
			border: 2px solid #eee;
			padding: 10px;
			border-radius: 15px;	
			outline: none;		
		}

		input:focus {
			border: 2px solid blue;			
		}
		button[type=button] {
			border: none;
			width: 70px;
			padding: 10px;
			background-color: green;
			color: white;
			border-radius: 7px;
			outline: none;
			cursor: pointer;
		}

		button[type=button]:hover {
			opacity: .4;
			background-color: green;
		}

		button:disabled {
			opacity: .4;
			cursor: inherit;
		}

	</style>
</head>
<body>
	<div class="container">
		<form id="login" method="post">
			<div class="input-container">
				<div class="col-input-hidden">
					<input type="hidden" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="browser" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>">
				</div>
				<div class="col-input">
					<label>FIN</label>
					<input type="text" name="finCode" required />
				</div>
				<div class="col-input">
					<label>ŞİFRƏ</label>
					<input type="password" name="password" required />
				</div>			
			</div>
			<p id="result"></p>	
		</form>
		<button type="button" id="mysubmit" name="mysubmit" onClick="javascript:sendForm('login')">Göndər</button>
	</div>

	<?php $this->load->view("script/script");?>

	<script type="text/javascript">
		
	  var SITE_URL = "http://localhost/payment_system/";

	    function sendForm(formID) {

			var myData=$("form#"+formID).serialize();
			var mySubmit = $("#mysubmit");

			$("#mysubmit").prop("disabled" ,true);

			mySubmit.html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>');
			
			$.ajax({
				type:"post",
				url:SITE_URL+"sign",
				data:myData,
				dataType:"json",
				success:function(data) {
					console.log(data);
					var result = $("#result");
					
						if(data.error) {
							$("#mysubmit").prop("disabled" ,false);
							result.css({
								padding:"10px",
								color:"red",
								marginBottom:"10px",
							});
							result.html(data.error);

							mySubmit.html('Göndər');
						} else if(data.warn) {
							$("#mysubmit").prop("disabled" ,false);
							result.css({
								padding:"10px",
								color:"#d57713",
								marginBottom:"10px",
							});
							result.html(data.warn);

							mySubmit.html('Göndər');
						} else {

							$("#mysubmit").prop("disabled" ,true);
							// <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
							result.css({
								padding:"10px",
								color:"#10a710",
								marginBottom:"10px",
							});
							
							result.html(data.success);
							mySubmit.html('Göndər');
						}
				}
			});
		}
	</script>

</body>
</html>

<?php
	}
?>