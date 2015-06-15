<?php
	
	$json = file_get_contents("ResolutionDatabaseExtrait.json");
	$parsed_json = json_decode($json);
	$compteur = 1;
	$tab = [];
	foreach ($parsed_json as $j){

		$tab["'".$compteur."'"] = $j;
	}

	echo json_encode($tab);

?>