<?php

	$plugin = $vars["entity"];
	
	echo "<div>";
	echo "<label>" . elgg_echo("walled_garden_by_ip:settings:allowed_ip") . "</label>";
	echo elgg_view("input/plaintext", array("name" => "params[allowed_ip]", "value" => $plugin->allowed_ip));
	echo "<div class='elgg-subtext'>" . elgg_echo("walled_garden_by_ip:settings:allowed_ip:description") . "</div>";
	echo "</div>";