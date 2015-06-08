<?php
	require 'connexion.php';

	$salle_selected = $_GET["salle"];

	$sql = "SELECT count(*) FROM secteur S1
			INNER JOIN secteur S2 ON S1.secteur_id = S2.secteur_parent_id
			WHERE S1.secteur_nom = '".$salle_selected."'";
	$salle = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));

	$ligne = mysqli_fetch_array($salle);
	$tab_salle[] = $ligne[0];		

	echo $tab_salle[0];
	
	//Fermeture de la connexion à la BDD
	mysqli_close($bdd);
?>