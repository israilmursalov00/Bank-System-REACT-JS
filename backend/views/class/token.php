<?php 


	class Token extends Session {

		public static function createToken() {

			return parent::create("USER_TOKEN", md5(uniqid(mt_rand())));
		}


		public static function control($token) {
			if(parent::isHave("USER_TOKEN") and $token == parent::get("USER_TOKEN")) {
				return true; 
			} else {
				return false;
			}
		}
	}



?>