<?php

	/**
	 * This function validates wether or not a user is allowed access to the site
	 * 
	 * Access is allowed in the following situations:
	 * 1) user is logged in and a member of the site
	 * 2) user is not loggedin but comes from an allowed IP address (plugin setting)
	 * 3) trying to access an external page (like index, about, term or login)
	 * 
	 */
	function walled_garden_by_ip_gatekeeper(){
		$result = false;
		$forward_url = "pg/login";
		
		$site = get_config("site");
		
		// check if the user is logged in and member of the site
		if(($user = get_loggedin_user()) && !empty($site) && ($site instanceof ElggSite)){
			$result = check_entity_relationship($user->getGUID(), "member_of_site", $site->getGUID());
		}
		
		// check if the user comes from an allowed IP
		if(!$result){
			$result = walled_garden_by_ip_validate_ip();
		}
		
		// check if the user is trying to access an external page
		if(!$result){
			$result = defined("externalpage");
		}
		
		// some pages are not registered as external but should be accessable
		if(!$result){
			$allowed_urls = array(
				"/account/forgotten_password.php",
				"/pg/register",
				"/pg/register/"
			);
			
			$url_path = parse_url(current_page_url(), PHP_URL_PATH);
			
			$result = in_array($url_path, $allowed_urls);
		}
		
		// User is not allowed access, so let him/her login
		if(!$result){
			if(!isset($_SESSION["last_forward_from"])){
				$_SESSION["last_forward_from"] = current_page_url();
			}
			
			// display a message to the user why not allowed
			if(!empty($user)){
				register_error(elgg_echo("walled_garden_by_ip:gatekeeper:user"));
			} else {
				register_error(elgg_echo("loggedinrequired"));
			}
			
			forward($forward_url);
		}
	}
	
	function walled_garden_by_ip_validate_ip(){
		$result = false;
		
		$client_ip = $_SERVER["REMOTE_ADDR"];
		$client_ip = trigger_plugin_hook("remote_address", "system", array("remote_address" => $client_ip), $client_ip);
		
		$allowed_ip = get_plugin_setting("allowed_ip", "walled_garden_by_ip");
		
		if(!empty($client_ip) && !empty($allowed_ip)){
			$allowed_ip = explode(PHP_EOL, $allowed_ip);
			
			require_once(dirname(dirname(__FILE__)) . "/vendors/pgregg/ip_check.php");
			
			foreach($allowed_ip as $check_ip){
				if(!empty($check_ip)){
					if($result = ip_in_range($client_ip, $check_ip)){
						// the IP address of the user is allowed, no point in searching any further
						break;
					}
				}
			}
		}
		
		return $result;
	}