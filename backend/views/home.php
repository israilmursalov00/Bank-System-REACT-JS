<?php		
	
	require_once "script/php_script.php";

	if(!Session::isHave("USER_LOGIN")) {
		go("index", 0.1);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bank | ev</title>
	<style type="text/css">
		body {
			font-family: cursive;
			margin: 0;
		}

		.row {
			padding: 20px;
			display: flex;
		}

		.table {
			margin-left: 10px;
			padding: 10px;
			border: 2px solid;
			background-color: #ccc;
			border-radius: 7px;
			width: 40%;
			font-size: 26px;
		}

		.table > span {
			font-size: 20px;
		}

		.table > p {
			margin: 0;
			margin-top: 10px !important;
		}

		.service-div {
			height: 100%;
			padding: 50px;
			background-color: #ccc;
			text-align: center;
			justify-content: center;
			border-radius: 10px;
			
		}

		.wrapper {
    		margin-top: 25px;
    		display: flex;
    		justify-content: center;
    		align-items: center;
    		align-self: center;
    		background-color: #eee;
    		height: 100%;
    		padding: 10px;
		}

		.service-cart {
			width: 200px;
			margin-top: 30px;
			border:2px solid #ccc;
			border-radius: 7px;
			background-color: white;
			margin-left: 10px;
			padding: 10px;
			cursor: pointer;
		}


		.service-cart:hover {
			border-bottom: 2px solid darkred;
		}


		img {
			width: 29%;
		}

		a {
			text-decoration: inherit;
			color: inherit;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Xoş gəldiniz <span id="user_name"></span></h1><br>

		<div class="row">
			<div class="table-1 table">
				<span>FIN və Hesab kimliyiniz</span>
				<p id="fin"></p>
			</div>
			<div class="table-2 table">
				<span>Bank Hesabında olan Məbləğ</span>
				<p id="money"></p>
			</div>
			<div class="table-3 table">
				<span></span>
				<p id="ip"></p>
			</div>
		</div>

		<div class="service-div">
			<div class="wrapper">
				<a href="cart_page">
					<div class="service-cart">
						<img src="https://api.million.az/media/million/services/1562587515_716292_bankciliq.svg"/>
						<p>Kartlarınız</p>
					</div>

				</a>
			</div>
		</div>
				<div class="service-div">
			<h2>Xidmətlər</h2>
			<div class="wrapper">
				<a href="cart_payment">
					<div class="service-cart">
						<img src="https://api.million.az/media/million/services/1562587515_716292_bankciliq.svg"/>
						<p>Kartdan karta ödəniş</p>
					</div>

				</a>
				<a href="payment_page">
					<div class="service-cart">
						<img src="https://api.million.az/media/million/services/1562587515_716292_bankciliq.svg"/>
						<p>Bank Hesabına ödəniş</p>
					</div>
				</a>
				<a href="create_cart">
					<div class="service-cart">
						<img src="https://api.million.az/media/million/services/1562587515_716292_bankciliq.svg"/>
						<p>Kartın açılması</p>
					</div>
				</a>
			</div>
		</div>
	</div>

	<?php $this->load->view("script/script");?>

	<script type="text/javascript">		

	var SITE_URL = "http://localhost/payment_system/";
	
	var myData = "<?php echo Session::get("USER_TOKEN");?>";

	
		function get() {
			$.ajax({
				type:"post",
				url:SITE_URL+"get_user",
				data:{
					"token":myData
				},
				dataType:"json",
				success:function(_data_) {
					var dataObj = {..._data_.data};	
						$("#user_name").css({
							color:"red"
						}); 

						$("#user_name").html(dataObj.name+" "+dataObj.lastname);
						$("#fin").html(dataObj.finCode);
						$("#money").html(dataObj.money+" Manat");	
				}
			});
		};

		get();


				$.ajax({
				type:"post",
				url:SITE_URL+"cookie",
				data:{
					"cookie_name":"cookie",
					"cookie_value":1
				},
				dataType:"json",
				success:function(_data_) {
					console.log(_data_);	
				}
			});

		function Quit() {
		 	return window.location.href="quit";
		}


	</script>
</body>
</html>