<?php

	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/hooks.php");
	
	function walled_garden_by_ip_init(){
		// register a php library
		elgg_register_library("pgregg.ipcheck", dirname(__FILE__) . "/vendors/pgregg/ip_check.php");
	}
	
	function walled_garden_by_ip_pagesetup(){
		// validate user access to this site
		walled_garden_by_ip_gatekeeper();
	}

	// register default Elgg events
	elgg_register_event_handler("init", "system", "walled_garden_by_ip_init");
	elgg_register_event_handler("pagesetup", "system", "walled_garden_by_ip_pagesetup");
	
	// plugin hooks
	elgg_register_plugin_hook_handler("public_pages", "walled_garden", "walled_garden_by_ip_walled_garden_hook");