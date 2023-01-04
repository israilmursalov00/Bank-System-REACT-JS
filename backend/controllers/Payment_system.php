<?php
defined('BASEPATH') or exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: *");

require_once "application/views/script/php_script.php";


class Payment_system extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("payment_module");
	}


	// Page view


	public function index()
	{
		$this->load->view('index');
	}

	public function home()
	{

		$this->load->view("home");
	}

	public function Login()
	{
		$this->load->view('login');
	}

	public function Register()
	{
		$this->load->view('register');
	}

	public function cart_page()
	{
		$this->load->view('cart_page');
	}


	public function payment_page()
	{
		$this->load->view('payment_send');
	}

	

	public function cart_payment()
	{
		$this->load->view('cart_payment'); 
	}

	public function create_cart()
	{
		$this->load->view('create_cart'); 
	}	


	public function quit()
	{
		$this->load->view('quit');
	}






	// Back end 





	public function sign()
	{

	if (empty($_POST) || $_GET) {
			go("index", 0.1);
			die();
		}

		$finCode = $_POST['finCode'];//$this->input->post("finCode");
		$password = md5(md5(sha1(md5($_POST['password']))));



		$ip = $_POST['ip'];
		$browser = $_POST['browser'];

		$retrData = [];

		if (($finCode === "undefined" || $password === "undefined") || ($finCode === "undefined" && $password === "undefined") || (empty($finCode) && empty($password)) || (empty($finCode) || empty($password))) {
			$retrData["error"] = "Xahiş edirik boş input buraxmayın";
		} else {

			sleep(25);

			$login = $this->payment_module->Login(array(
				"finCode" => $finCode, 
				"password" => $password
			));

			$user_id = $this->payment_module->get_user_id($finCode);

			$user_display = $this->payment_module->user_display($user_id);

			$retrData['data']=$login;
			if ($login) {
				if($user_display) {
					if ($login->ip == $ip) {
						if ($login->browser_about == $browser) {
							
							// PHP LOCAL 

							$retrData["success"] = "Giriş uğurludur";
							
							$retrData["USER_TOKEN"] = $login->token;

							Session::create("USER_TOKEN", $login->token);

							Session::create("USER_ID", $login->ID);

							Session::create("USER_LOGIN", true);

							// REACT 

							$retrData['ID']=$login->ID;


							$retrData["browser_token"] = $login->user_browser_token;
						
						} else {
							$retrData["error"] = "Giriş olarkən bir xəta baş verdi";
							
						}
					} else {
						$retrData["error"] = "Giriş olarkən bir xəta baş verdi";
					}

				// user sign (true or false) 

				} else {
					$retrData["error"] = "Bu hesaba giriş mümkün olmadı. Xahiş edirik, əməkdaşlarımız ilə əlaqəyə keçin";
				}
		
			} else {
				$retrData["error"] = "FIN vəya Parol Yanlışdır";
				$retrData['login']=[$finCode,$password];
			};
		}

		echo json_encode($retrData);
	}









	public function RegisterClient()
	{



		if(empty($_POST) || $_GET) {
			go("index",0.1);
			die();
		
		} else {


		$userName =  $_POST['name'];//$this->input->post("name");
		$lastname =  $_POST['lastname'];//$this->input->post("lastname");
		$finCode =  $_POST['finCode'];//$this->input->post("finCode");
		$badher =  $_POST['badher'];//$this->input->post("badher");
		$mather =  $_POST['mather'];//$this->input->post("mather");
		$password =  md5(md5(sha1(md5($_POST['password']))));
		$token = $_POST['token'];//$this->input->post("token");

		$retrData = [];


		if (($userName === "undefined"||$lastname === "undefined" ||$finCode === "undefined" || $password === "undefined"||$badher=="undefined"||$mather==="undefined") || ($userName === "undefined" && $lastname === "undefined" ||$finCode === "undefined" && $password === "undefined" && $badher=="undefined" && $mather==="undefined")|| (empty($finCode) && empty($password)) || (empty($finCode) || empty($password))) {

			$retrData["error"] = "Xahiş edirik boş input buraxmayın";
		} else {


			sleep(5);

		  //if() {
			$register = $this->payment_module->Insert(
				"user",
				array(
					"name" => $userName,
					"lastname" => $lastname,
					"finCode" => $finCode,
					"bName" => $badher,
					"mName" => $mather,
					"password" => $password,
					"token" =>  md5(md5(sha1(md5($token)))),
					"user_browser_token" => sha1(md5(rand(5, 20)))

				)
			);

			// client sign about --> ip, browser about


			$ip_address = $this->input->post("ip");
			$browser = $this->input->post("browser");



			$client_about = $this->payment_module->Insert(
				"client_about",
				array(
					"ip" => $ip_address,
					"browser_about" => $browser
				)
			);


			// user payment


			
			if ($register && $client_about) {

				$client_payment = $this->payment_module->Insert(
					"payment",
					array(
						"money" => 500
					)
				);

				$retrData["success"] = "Uğurla qeydiyyat yerinə yetirildi.";
				$retrData["password"]=$password;

			}

		// }


		} // else close

		}


		echo json_encode($retrData);
	}









	public function get_user()
	{

		if (empty($_POST) || $_GET) {
			go("index", 0.1);
		}


		$_token_ = $_POST['token'];

		$retrnData = [];

		$data = $this->payment_module->get_token_data($_token_);

		$user_display = $this->payment_module->user_display($data->ID);

		if ($data) {
			if($user_display) {
			  	
			  	$retrnData['data'] = $data;
			} else {
				return session_destroy();
			}
		} else {
			$retrnData['error'] = "Error";
		}

		echo json_encode($retrnData);
	}












	public function cart()
	{


		if (empty($_POST) || $_GET) {
			go("home", 0.1);
			die();
		}


		$token = $_POST['token'];

		$user_id = $this->payment_module->get_token_id($token);

		$cart_name = $this->input->post("cart_name");
		
		$valyuta = $this->input->post("valyuta");

		
		$retrnData = [];

		if (empty($cart_name)) { 
			$retrnData['error'] = "Xahiş edirik boş input buraxmayın";
		} else {
			
			sleep(5);

			$new_cart_number = rand();

			$data = $this->payment_module->Insert(
				"user_cart",
				array(
					"user_id" => $user_id,
					"cart_name" => $cart_name,
					"cart_number" => $new_cart_number
				)
			);


			$cart_id = $this->payment_module->get_cart_id($new_cart_number);


			$valyuta = $this->payment_module->Insert(
				"valyuta",
				array(
					"cart_id" => $cart_id,
					"valyuta_name" => $valyuta
				)
			);

			if ($data && $valyuta) {
				$retrnData['success'] = "Uğurla kart açıldı";
			} else {
				$retrnData['error'] = "Xəta baş verdi";
			}
		}

		echo json_encode($retrnData);
	}














	public function get_cart()
	{

		if (empty($_POST) || $_GET) {

			go("home", 0.1);
			die();
		} else {
			sleep(3);

			$retrnData = [];

			$token = $_POST['token'];

			$user_id = $this->payment_module->get_token_id($token);


			$cart_data = $this->payment_module->get_cart_data($user_id);
			
			if ($cart_data) {
				$retrnData['data'] = $cart_data;

			} else {
				$retrnData['null'] = "Bazada sizə aid kart yoxdur";
			}

			echo json_encode($retrnData);
		}
	}















	public function payment_send()
	{
		if (empty($_POST) || $_GET) {
			go("index", 0.1);
			die();
		} else {

		 // <!------ USER PAYMENT SEND BANK ACCOUNT --->
			

			$token = $_POST['token'];

			$user_id = $this->payment_module->get_token_id($token);

			$payment_user_fin = $this->input->post("payment_user_fin");

			$payment_type = $this->input->post("payment_type");

			$payment_money = $this->input->post("payment_money");

			$retrnData = [];

			if ((empty($payment_user_fin) &&  (empty($payment_money))) || (empty($payment_user_fin) ||  (empty($payment_money)))) {

				$retrnData['error'] = "Xahiş edirik boş input buraxmayın";
			} else {
			
				sleep(5);

				$member_id = $this->payment_module->get_user_id($payment_user_fin); // member id

				$member_display = $this->payment_module->user_display($member_id);

				$user_display = $this->payment_module->user_display($user_id);

				if ($member_id) {
						

						if($user_id !== $member_id) { 

							if($member_display && $user_display) {
						// gondermek isteyenin meblegi

						$user_payment = $this->payment_module->get_payment($user_id);

						$member_payment = $this->payment_module->get_payment($member_id);

						foreach ($user_payment as $payment_data) {
							foreach ($member_payment as $payment) {


								$user_money = $payment_data->money;

								$member_money = $payment->money;

								if ($user_money >= $payment_money) {

									$payment_send = $this->payment_module->user_payment_send($member_id, ($member_money + $payment_money));


									if ($payment_send) {
										$payment_ext = $this->payment_module->user_payment_send($user_id, ($user_money - $payment_money));

										if ($payment_ext) {
											$retrnData['success'] = "Pul hesaba köçürüldü";
										}
									}
								} else {
									$retrnData['error'] = "Hesabda kifayyət qədər vəsait yoxdur";
								}
							}
						}

							} else {
								$retrnData['error'] = "Gözlənilməz xəta baş verdi";
							}
						} else {
							$retrnData['error'] = "Öz özünüzə pul göndərə bilməsiniz";
						}
					} else {
					$retrnData['error'] = "Belə bir istifadəçi tapılmadı";
				}

			  // <!------ USER PAYMENT SEND BANK ACCOUNT END --->

			} // 2 else end 
			echo json_encode($retrnData);
		}

	}














	public function payment_cart()
	{



		$token = $_POST['token'];

		$user_id = $this->payment_module->get_token_id($token);

		$member_cart_number = $this->input->post("member_cart_number");

		$user_cart_number = $this->input->post("user_cart_number");

		$payment_send_money = $this->input->post("payment_money");

		$retrnData=[];

		if(($member_cart_number == "undefined" && $payment_send_money == "undefined") || ($member_cart_number == "undefined" || $payment_send_money == "undefined")) {

			$retrnData['error']="Boş input buraxmayın";


		} else {

			if($user_cart_number == "undefined") {
				$retrnData['error']="Sizə aid kart seçin";
			} else {
			
			sleep(5);

			$user_display = $this->payment_module->user_display($user_id);
			
			$cart_id = $this->payment_module->get_cart_id($member_cart_number);

			if($user_display) {

			if($cart_id) {
			 
			 if($user_cart_number !== $member_cart_number){
				
					$member_cart_money = $this->payment_module->get_cart_payment($member_cart_number);

					$user_cart_money = $this->payment_module->get_cart_payment($user_cart_number);

				
				if($user_cart_money >= $payment_send_money) {

					$user_cart_display = $this->payment_module->cart_display($user_cart_number);

					$member_cart_display = $this->payment_module->cart_display($member_cart_number);

					if($user_cart_display && $member_cart_display) {


						$payment_send = $this->payment_module->cart_payment($member_cart_number,($member_cart_money+$payment_send_money)); 

						if($payment_send) {
							$payment_ext = $this->payment_module->cart_payment($user_cart_number,($user_cart_money-$payment_send_money));

							if($payment_ext) {
								$retrnData['success']="Pul karta köçürüldü";
							}
						}
					} else {
						$retrnData['error']="Gözlənilməz xəta baş verdi";
					}
				} else {
					$retrnData['error']="Kartda kifayyət qədər vəsait yoxdur";
				}
       		  } else {
       		  	$retrnData['error']="Öz özünüzə pul göndərə bilməsiniz";
       		  }
			} else {
				$retrnData['error']="Kart məlumatları yanlış girilib";
			}

			} else {
				$retrnData['error']="Gözlənilməz xəta baş verdi";
			}

			}

		} // first else

			echo json_encode($retrnData);
	
	} // function end


    // react api browser and ip

	public function user_info()
	{
		$operation = $_POST['opr'];

		$retrnData=[];

		switch ($operation) {
			case 'login':

				$retrnData['browser']=$_SERVER['HTTP_USER_AGENT'];
			
				$retrnData['ip']=$_SERVER['SERVER_ADDR'];
			
				break;
			
			case 'register':
			
				$retrnData['browser']=$_SERVER['HTTP_USER_AGENT'];
			
				$retrnData['ip']=$_SERVER['SERVER_ADDR'];
			
				$retrnData['USER_NEW_TOKEN']=Token::createToken();
			
				break;
			
			case 'home':
			
				$browser_token=$_POST['browser_token'];

				$user_token = $this->payment_module->get_user_token($browser_token);

				$retrnData['USER_TOKEN']=$user_token;

				break;				
			
			default:break;
		}
		
		echo json_encode($retrnData);
	}


} // class end