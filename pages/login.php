<?php

	define("externalpage", true);
	
	// build page elements
	$title_text = elgg_echo("login");
	
	$body = elgg_view("walled_garden_by_ip/login");
	
	// draw page
	page_draw($title_text, elgg_view_layout("one_column", $body));