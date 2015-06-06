<?php
	require 'connexion.php';

	$salle_selected = $_GET["salle"];

	$sql = "SELECT * FROM salle WHERE salle_nom = '".$salle_selected."'";
	$salle = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));

	$ligne = mysqli_fetch_array($salle);

	//echo $ligne[0];
	//echo $ligne[1];
	echo $ligne[2].'<br/>'.$ligne[3].'<br/>'.$ligne[4];

	
	//Fermeture de la connexion à la BDD
	mysqli_close($bdd);
?>