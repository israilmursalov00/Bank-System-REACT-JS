<?php		
	
	require_once "script/php_script.php";

	if(!Session::isHave("USER_LOGIN")) {
		go("index",0.1);
	}
	//session_destroy();
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bank | cart</title>
	<style type="text/css">
		body {
			margin: 0;
			font-family: cursive;
		}

		.container {
			padding: 10px;
		}
		.carts > div {
			width: 50%;
			border-radius: 5px;
			border:2px solid #ccc;
			margin: 10px;
			text-align: center;	
			font-size: 20px;
		}


		.cart_about {
			color: darkred;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<h1>Cart Page</h1>

			<div class="carts">
				<p id="result"></p>	
			</div>
		</div>
	</div>

	<?php $this->load->view("script/script");?>

	<script type="text/javascript">

		var SITE_URL = "http://localhost/payment_system/";		
		
		function get_cart() {
			 $.ajax({
				type:"post",
				url:SITE_URL+"get_cart",
				data:{
					"USER_ID":'<?php echo Session::get("USER_ID");?>'
				},
				dataType:"json",
				success:function(_data_) {

					var cart_con = $(".carts");
					var result = $("#result");

					if(_data_.null) {
						result.css({
							color:"black"
						});

						result.html(_data_.null);
					} else {
						
						var cart_arr = _data_.data;
						for (var i = 0; i <= cart_arr.length; i++) {				var cart_row = document.createElement("div");	

									cart_row.innerHTML=`
										<div>
											<span>Kartın Adı</span>
											<p class='cart_about'>${cart_arr[i].cart_name}</p>
											<span>Kartın Nömrəsi</span>
											<p class='cart_about'>${cart_arr[i].cart_number}</p>
											<span>Kartda olan məbləğ</span>
											<p class='cart_about'>${cart_arr[i].cart_money} ${cart_arr[i].valyuta_name}</p>
										</div><br>`;
								cart_con.append(cart_row);
						}

				} // else close
			}
		});
	}


		let calls=get_cart();

	</script>
</body>
</html>