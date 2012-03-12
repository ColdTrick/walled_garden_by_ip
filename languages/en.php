<?php

	$english = array(
		'walled_garden_by_ip' => "Walled Garden by IP",
		
		'walled_garden_by_ip:gatekeeper:user' => "You need to be a member of this site to view the requested page",
		
		'walled_garden_by_ip:settings:allowed_ip' => "Whitelist IP addresses",
		'walled_garden_by_ip:settings:allowed_ip:description' => "The allowed IP addresses must be listed one per line in one of the follwing formats<br />
		1. Wildcard format: 1.2.3.*<br />
		2. CIDR format: 1.2.3/24  OR  1.2.3.4/255.255.255.0<br />
		3. Start-End IP format: 1.2.3.0-1.2.3.255",
		
		'' => "",
	);
	
	add_translation("en", $english);