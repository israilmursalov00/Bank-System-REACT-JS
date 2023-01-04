<?php
	session_start();
	error_reporting(0);
	
	require_once "application/controllers/Payment_system.php";

	require_once "application/views/functions/routing.php";

	require "application/views/class/session.php";
	
	require_once "application/views/class/token.php";

?>