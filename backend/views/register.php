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
	<title>Register | Bank</title>
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

		#success {
			padding: 10px;
			border-radius: 5px;
			border: 2px solid #54c357;
			background-color: #54c357;
			color:#eee;
			display: none;
			width: 20%;

		}


		button:disabled {
			opacity: .4;
			cursor: inherit;
		}

	</style>
</head>
<body>
	<div class="container">
		<form id="register" method="post">
			<div class="input-container">
				<div class="col-input-hidden">
					<input type="hidden" name="token" id="token" value="<?php echo Token::createToken();?>" />
					<input type="hidden" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR'];?>" />
					<input type="hidden" name="browser" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>" />
				</div>
				<div class="col-input">
					<label>ADI</label>
					<input type="text" name="name"/>
				</div>
				<div class="col-input">
					<label>SOYADI</label>
					<input type="text" name="lastname"/>
				</div>
				<div class="col-input">
					<label>FIN</label>
					<input type="text" name="finCode"/>
				</div>
				<div class="col-input">
					<label>ATA ADI</label>
					<input type="text" name="badher"/>
				</div>
				<div class="col-input">
					<label>ANA ADI</label>
					<input type="text" name="mather"/>
				</div>
				<div class="col-input">
					<label>ŞİFRƏ</label>
					<input type="password" name="password"/>
				</div>				
			</div>
			<p id="result"></p>
		</form>
		<button type="button" id="mysubmit" name="mysubmit" onClick="javascript:sendForm('register')">Göndər</button>
	</div>

	<?php $this->load->view("script/script");?>

	<script type="text/javascript">
		
	  var SITE_URL = "http://localhost/payment_system/";


		function sendForm(formID) {

			$("#mysubmit").prop("disabled",true);

			var myData=$("form#"+formID).serialize();
			var result=$("#result");
			
			$.ajax({
				type:"post",
				url:SITE_URL+"RegisterClient",
				data:myData,
				dataType:"json",
				success:function(data) {
					
					if(data.warn) {
						result.css({
							padding:"10px",
							borderRadius:"10px",
							border:`1px solid #d57713`,
							backgroundColor:"#d57713",
							color:"#eee",
						});
						result.html(data.warn);
					} else if (data.error) {
							result.css({
								padding:"10px",
								borderRadius:"10px",
								border:`1px solid red`,
								backgroundColor:"red",
								color:"#eee",
								
							});	
							result.html(data.error);					
					} else {
						$("#mysubmit").prop("disabled" ,true);
						result.css({
							padding:"10px",
							borderRadius:"10px",
							border:`1px solid #10a710`,
							backgroundColor:"#10a710",
							color:"#eee",
							
						});
						result.html(data.success);						
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