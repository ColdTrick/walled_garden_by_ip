<?php

	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/hooks.php");
	
	function walled_garden_by_ip_pagesetup(){
		// validate user access to this site
		walled_garden_by_ip_gatekeeper();
	}

	// register default Elgg events
	elgg_register_event_handler("pagesetup", "system", "walled_garden_by_ip_pagesetup");
	
	// plugin hooks
	elgg_register_plugin_hook_handler("public_pages", "walled_garden", "walled_garden_by_ip_walled_garden_hook");