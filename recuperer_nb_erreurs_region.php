<?php
	require 'connexion.php';

	$id_salle = $_GET["salle"];
	
	
	$nb_erreurs = 0;
	$nb_cours = 0;
	$nb_erreurs_cours = [];

	$sql = "SELECT region_ID FROM region_salle WHERE salle_ID = '".$id_salle."'";
	$region = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
	$region = mysqli_fetch_row($region);
	
	$sql = "SELECT salle_ID FROM region_salle WHERE region_ID = '".$region[0]."'";
	$lst_salle = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
	

	while ($compteur_salle = mysqli_fetch_row($lst_salle)){

		//
		
		$sql = "SELECT cours_ID FROM cours WHERE cours_salle_ID = '".$compteur_salle[0]."'";
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
		
		

		
	}

	array_push($nb_erreurs_cours, $nb_erreurs);
	array_push($nb_erreurs_cours, $nb_cours);
	
	echo json_encode($nb_erreurs_cours);

	mysqli_close($bdd);
?>