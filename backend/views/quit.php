<?php

	if (empty($_POST) || $_GET) {
		go("index",0.1);
	}

	session_start();
	session_destroy();
?>