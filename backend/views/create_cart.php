<?php
	
	if (!Session::isHave("USER_LOGIN")) {
		go("index",0.1);

		die();
	}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bank | Payment</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<style type="text/css">
			
		body {
			font-family: sans-serif;
		}

		.container {
			padding: 10px;
			background-color: #eee;
			border: 10px;
			margin-top: 60px;
		}

		.input {
			padding: 25px;
		}

		.input > select,input {
			width: 250px;
			padding: 10px;
			border:2px solid darkorange;
			border-radius: 10px;
			outline: none;
		}

		button[type=button] {
			padding: 10px;
			width: 100px;
			border: none;
			border-radius: 6px;
			background-color: #13a8ce;
			color: white;
			cursor: pointer;
			outline: none;
		} 

		button[type=button]:hover {
			opacity: .4;
		}

		button:disabled {
			opacity: .4;
			cursor: inherit;
		}


	</style>
</head>
<body>
	<div class="container">
		<div class="input">
			<form id="payment_form" method="post">
				<input type="name" name="cart_name" id="cart_name" placeholder="Kartın Adı (Mastercart, visa)"><br><br>
				<select class="form-select w-25" id="select_payment_valyuta">
					<option value="null">Valyuta Seçin</option>
					<option value="AZN">AZN</option>
					<option value="EUR">EURO</option>
					<option value="TRY">TRY</option>
				</select>
				<p id="result"></p>
			</form>
		<button type="button" id="mysubmit" onclick="javascript:create_cart();">Kart Aç</button>
		</div>

		
	</div>
	<?php $this->load->view("script/script");?>

	<script type="text/javascript">

	  var SITE_URL = "http://localhost/payment_system/";


		function create_cart() {


			var result = $("#result");

		    var mySubmit = $("#mysubmit");

			$("#mysubmit").prop("disabled" ,true);

			mySubmit.html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>');

			$.ajax({
				type:"post",
				url:SITE_URL+"cart",
				data:{
					"user_id": "<?php echo Session::get('USER_ID');?>",
					"cart_name":$("#cart_name").val(),
					"valyuta":$("#select_payment_valyuta").val()
				},
				dataType:"json",
				success:function(_data_) {
					if(_data_.success) {
						$("#mysubmit").prop("disabled" ,false);
						$("#result").css({
							color:"green"
						}); 						
						$("#result").html(_data_.success);
						mySubmit.html('Kart Aç');	
					} else if(_data_.warn) {
						$("#mysubmit").prop("disabled" ,false);
						$("#result").css({
							color:"#e0b600"
						}); 						
						$("#result").html(_data_.warn);

						mySubmit.html('Kart Aç');
					} else {

						$("#mysubmit").prop("disabled" ,true);
						$("#result").css({
							color:"red"
						});						
						$("#result").html(_data_.error);
						mySubmit.html('Kart Aç');
					}
				}

			});		

			$.ajax({
				type:"http://localhost/payment_system/cookie",
					url:SITE_URL+"cookie",
					data:{
						"cookie_name":"login",
						"cookie_value":123
					},
					dataType:"json",
					success:(data) => {
						console.log(data);
					}
				});
		}
	</script>
</body>
</html>