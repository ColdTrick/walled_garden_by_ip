<?php

	function walled_garden_by_ip_walled_garden_hook($hook, $type, $return_value, $params){
		$result = $return_value;
		
		if(!elgg_get_config("walled_garden")){
			$result[] = "login";
		}
		
		return $result;
	}