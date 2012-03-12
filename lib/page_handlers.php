<?php

	function walled_garden_by_ip_login_page_handler($page){
		
		include(dirname(dirname(__FILE__)) . "/pages/login.php");
		return true;
	}