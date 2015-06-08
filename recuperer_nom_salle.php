<?php
	require 'connexion.php';

	$salle_selected = $_GET["salle"];


	$sql = "SELECT S2.secteur_nom FROM secteur S1
			INNER JOIN secteur S2 ON S1.secteur_nom = '".$salle_selected."'
			WHERE S1.secteur_id = S2.secteur_parent_id OR (S1.secteur_id = S2.secteur_id AND S1.secteur_niveau = 3)";
	$salle = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));


	$i = 0;
	while($ligne = mysqli_fetch_array($salle)){
	$tab_salle[] = $ligne[0];		
	echo $tab_salle[$i].'<br/>';
	$i++;
	}

	
	//Fermeture de la connexion à la BDD
	mysqli_close($bdd);
?>