<?php
	require 'connexion.php';

	$id_salle = $_GET["salle"];
	//$id_salle = 3;
	
	$nb_erreurs = 0;
	$nb_cours = 0;
	$nb_erreurs_cours = [];

	
		
	$sql = "SELECT cours_ID FROM cours WHERE cours_salle_ID = '".$id_salle."'";
	$lst_cours = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));

	while ($compteur_cours = mysqli_fetch_row($lst_cours)){
		$nb_cours ++;
		$sql = "SELECT COUNT(*) FROM erreurs WHERE id_cours_reference = '".$compteur_cours[0]."'";
		$count_erreur = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
		$count_erreur = mysqli_fetch_row($count_erreur);

		if ($count_erreur[0] != 0){
			
			$nb_erreurs ++;

		}

	}
		

	array_push($nb_erreurs_cours, $nb_erreurs);
	array_push($nb_erreurs_cours, $nb_cours);
	
	echo json_encode($nb_erreurs_cours);

	mysqli_close($bdd);
?>