<?php

	class Payment_module extends CI_Model {
		public function __construct() {
			parent::__construct();
		}


		

		public function get_user($token) {

			return $this->db->query("SELECT user.name FROM user WHERE token=?",$token)->result();

		}



	    public function Insert($tableNames, $data = array()) {
			
			return $this->db->insert($tableNames, $data);
		}



	    public function Login($data = array()) {

			
			$loginCon = $this->db->query("SELECT user.ID,user.name, user.lastname, user.token,user.userBlock,user.user_browser_token,client_about.ip,client_about.browser_about FROM user NATURAL JOIN client_about WHERE user.finCode=? AND user.password=?",$data)->result();

				
			foreach ($loginCon as $value) {
				if($value->userBlock == 0) {
					return $value;
				} else {
					return false;
				}
			}
			
		}


		public function get_token_data($data) { 
			
			$datas = $this->db->query("SELECT user.ID, user.name, user.lastname, user.finCode,user.bName,user.mName,payment.money,client_about.ip,client_about.browser_about FROM user NATURAL JOIN client_about NATURAL JOIN payment WHERE user.token=?;",$data)->result();

			foreach ($datas as $value) {
				return $value;
			}			
		}
		

		public function get_cart_data($user_id) {
			
			$datas = $this->db->query("SELECT * FROM user_cart INNER JOIN user ON user_cart.user_id=user.ID INNER JOIN valyuta ON user_cart.ID=valyuta.cart_id WHERE user_cart.cart_display=1 AND user_cart.user_id=?",$user_id)->result();

			return $datas;	
		}




		public function get_user_id($finCode) {

			$data=$this->db->query("SELECT user.ID FROM user WHERE finCode=?",$finCode)->result();

				foreach ($data as $value) {
					if($value->ID) {
						return $value->ID;
					} else {
						return false;
					}
				}
		}


		public function get_token_id($token)
		{
			$data=$this->db->query("SELECT user.ID FROM user WHERE user.token=?",$token)->result();

				foreach ($data as $value) {
					if($value->ID) {
						return $value->ID;
					} else {
						return false;
					}
				}
		}


		public function user_payment_send($id, $payment_money) {

			$this->db->where('ID', $id);
			$this->db->update('payment', array("money" => $payment_money));
			return true;	
		}


		public function get_payment($user_payment_id) {
			sleep(3);
			$datas = $this->db->query("SELECT payment.money FROM payment WHERE payment.ID=?",$user_payment_id)->result();

			return $datas;
		}

		public function user_display($id) {
			$datas = $this->db->query("SELECT user.userDisplay FROM user WHERE user.ID=?",$id)->result();

			foreach ($datas as $value) {
				return $value->userDisplay == 1 ? true : false;
			}			
		}


		public function get_user_token($browser_token)
		{
			$datas = $this->db->query("SELECT user.token FROM user WHERE user.user_browser_token=?",$browser_token)->result();

			foreach ($datas as $value) {
				return $value->token;
			}
		}



		// <!--- CART PAYMENT SYSTEM --->

		

		public function get_cart_id($number) 
		{
			$datas = $this->db->query("SELECT ID FROM user_cart WHERE user_cart.cart_number=?;",$number)->result();

			foreach ($datas as $value) {
					if($value->ID) {
						return $value->ID;
					} else {
						return false;
					}
				}	
		}

		public function get_cart_payment($cart_number) 
		{
			$datas = $this->db->query("SELECT cart_money FROM user_cart WHERE user_cart.cart_number=?;",$cart_number)->result();

			foreach ($datas as $value) {
					if($value->cart_money) {
						return $value->cart_money;
					} else {
						return false;
					}
				}			
		}

		public function cart_display($cart_number)
		{
			$datas = $this->db->query("SELECT cart_display FROM user_cart WHERE user_cart.cart_number=?;",$cart_number)->result();

			foreach ($datas as $value) {
					if($value->cart_display == 1) {
						return true;
					} else {
						return false;
					}
				}
		}



		public function cart_payment($number, $payment_money) {

			$this->db->where('cart_number', $number);
			$this->db->update('user_cart', array("cart_money" => $payment_money));
			return true;	
		}

		

	}


 /*

	// DATABASE RESET

	SET @autoid :=0;

	UPDATE table_name SET ID=@autoid := (@autoid+1);

	ALTER TABLE table_name AUTO_INCREMENT=1;


 */

?>