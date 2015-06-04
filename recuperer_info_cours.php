<?php
	//Connexion à la BDD
		require 'connexion.php';

	$sql ="SELECT * FROM cours WHERE cours_ID = ".$cours_selected."";
	$coursInfos = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
	
	echo $coursInfos;
	
	//Fermeture de la connexion à la BDD
		mysqli_close($bdd);
?>