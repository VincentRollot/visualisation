<?php
	require 'connexion.php';

	$id_cours = $_GET["cours"];
	

	$sql = "SELECT msg_erreur FROM erreurs WHERE id_cours_reference = '".$id_cours."'";
	$erreurs = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));


	$lst_erreurs = [];
	while ($compteur = mysqli_fetch_row($erreurs)){

		array_push($lst_erreurs, $compteur[0]);
		
	}
	
		
	echo json_encode($lst_erreurs)."</br>";
	
	
	//Fermeture de la connexion à la BDD
	mysqli_close($bdd);
?>