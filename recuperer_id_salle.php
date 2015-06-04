<?php
	//Connexion à la BDD
		require 'connexion.php';

	$sql ="SELECT salle_ID FROM salle WHERE salle_nom = ".$salle_selected."";
	$salle = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
	
	echo $salle;
	
	//Fermeture de la connexion à la BDD
		mysqli_close($bdd);
?>