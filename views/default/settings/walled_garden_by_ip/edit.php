<?php

	$plugin = $vars["entity"];
	
	echo "<div>" . elgg_echo("walled_garden_by_ip:settings:allowed_ip") . "</div>";
	echo elgg_view("input/plaintext", array("internalname" => "params[allowed_ip]", "value" => $plugin->allowed_ip));
	echo "<div>" . elgg_echo("walled_garden_by_ip:settings:allowed_ip:description") . "</div>";