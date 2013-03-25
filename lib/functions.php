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
		// User is not allowed access, so let him/her login
		if(!walled_garden_by_ip_validate_access()){
			if(!isset($_SESSION["last_forward_from"])){
				$_SESSION["last_forward_from"] = current_page_url();
			}
			
			// display a message to the user why not allowed
			if(elgg_is_logged_in()){
				register_error(elgg_echo("walled_garden_by_ip:gatekeeper:user"));
			} else {
				register_error(elgg_echo("loggedinrequired"));
			}
			
			forward("login");
		}
	}
	
	function walled_garden_by_ip_validate_access(){
		$result = false;
		
		$site = elgg_get_site_entity();
		
		// check if the user is logged in and member of the site
		if(($user = elgg_get_logged_in_user_entity()) && !empty($site) && elgg_instanceof($site, "site", null, "ElggSite")){
			$result = check_entity_relationship($user->getGUID(), "member_of_site", $site->getGUID());
		}
		
		// check if the user comes from an allowed IP
		if(!$result){
			$result = walled_garden_by_ip_validate_ip();
		}
		
		// check if the user is trying to access a public page
		if(!$result){
			$result = $site->isPublicPage();
			
			// extra check
			if($result && !elgg_get_config("walled_garden")){
				if(elgg_in_context("main")){
					$result = false;
				}
			}
		}
		
		return $result;
	}
	
	function walled_garden_by_ip_validate_ip(){
		$result = false;
		
		$client_ip = $_SERVER["REMOTE_ADDR"];
		$client_ip = elgg_trigger_plugin_hook("remote_address", "system", array("remote_address" => $client_ip), $client_ip);
		
		$allowed_ip = elgg_get_plugin_setting("allowed_ip", "walled_garden_by_ip");
		
		if(!empty($client_ip) && !empty($allowed_ip)){
			$allowed_ip = explode(PHP_EOL, $allowed_ip);
			
			// load validation library
			elgg_load_library("pgregg.ipcheck");
			
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