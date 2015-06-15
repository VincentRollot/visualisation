<?php
	require 'connexion.php';

	$id_salle = $_GET["cours"];
	$debut_semaine = $_GET["date"];;
	
	$lst_intensite = [];

	$sql = "SELECT class_level, description FROM intensite";
	$lst_intensite_BDD = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));

	while ($compteur_intensite = mysqli_fetch_row($lst_intensite_BDD)){

		$sql = "SELECT COUNT(*) FROM (SELECT * FROM cours WHERE cours_salle_ID = '".$id_salle."' AND cours_date BETWEEN '".$debut_semaine."' AND DATE_ADD('".$debut_semaine."', INTERVAL 6 DAY)) AS D WHERE cours_type = '".$compteur_intensite[0]."'";
		$nb_cours = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
		$nb_cours = mysqli_fetch_row($nb_cours);

		if ($nb_cours[0] > 0){

			$lst_intensite[$compteur_intensite[1]] = $nb_cours[0];
		}
	}

	echo json_encode($lst_intensite);
	mysqli_close($bdd);
?>