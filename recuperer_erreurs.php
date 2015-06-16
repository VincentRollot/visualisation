<?php
	require 'connexion.php';


	$sql = "SELECT id_cours_reference, msg_erreur FROM erreurs";
	$erreurs = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));


	$lst_erreurs = [];
	while ($compteur = mysqli_fetch_row($erreurs)){

		array_push($lst_erreurs, $compteur[0], $compteur[1]);
		
	}

	echo json_encode($lst_erreurs)."</br>";
	
	//Fermeture de la connexion à la BDD
	mysqli_close($bdd);
?>