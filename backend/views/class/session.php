<?php
	
	class Session
	{
		
		public static function create($name,$value) {
			return $_SESSION[$name]=$value;
		}

		public static function isHave($name) {
			return isset($_SESSION[$name]) ? true : false;
		}


		public static function get($name) {
			if(self::isHave($name)) {
				return $_SESSION[$name];
			} else {
				return false;
			}
		}

		public static function del($name) {
			if(self::isHave($name)) {
				unset($_SESSION[$name]);
			}
		}		
	}



?>