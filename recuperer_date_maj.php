<?php
	require 'connexion.php';

	$sql = "SELECT date_maj FROM date_maj ORDER BY date_maj DESC LIMIT 1";
	$salle = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));

	$ligne = mysqli_fetch_array($salle);
	$tab_salle[] = $ligne[0];
		

	echo $tab_salle[0];
	
	//Fermeture de la connexion à la BDD
	mysqli_close($bdd);
?>