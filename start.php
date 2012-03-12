<?php

	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/page_handlers.php");

	function walled_garden_by_ip_init(){
		// extend CSS
		elgg_extend_view("css", "walled_garden_by_ip/css");
		
		// register page_handler for login
		register_page_handler("login", "walled_garden_by_ip_login_page_handler");
	}
	
	function walled_garden_by_ip_pagesetup(){
		// validate user access to this site
		walled_garden_by_ip_gatekeeper();
	}

	// register default Elgg events
	register_elgg_event_handler("init", "system", "walled_garden_by_ip_init");
	register_elgg_event_handler("pagesetup", "system", "walled_garden_by_ip_pagesetup");