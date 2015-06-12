<?php
	
	echo "Ouverture de indicateur_taux_erreur.php<br/>";
	require 'connexion.php';
	
	// Temps sur distance < 0.02
	//Insérer les salles : table SALLE
	//Chemin JSON pour récupérer les salles
	$chemin= getcwd ();
	
	//echo $chemin;
	$json_resolution = file_get_contents("./planningResoluV2.json");
	$parsed_json_resolution = json_decode($json_resolution);


	//Boucle sur les cours du JSON
	foreach ($parsed_json_resolution as $cours){

		$c_class_id = $cours->{'classroom_id'};
		$c_ID = $cours->{'class_id'};

		$query = "SELECT region_ID FROM region_salle WHERE salle_ID = ".$c_class_id;
		$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		$region_id = mysqli_fetch_row($sql);

		$query = "SELECT COUNT(*) FROM erreurs WHERE id_cours_reference = ".$c_ID;
		$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		$nb_erreur = mysqli_fetch_row($sql);

		$query = "SELECT indicateur_ID FROM indicateurs WHERE id_type_indicateur = 1 AND id_element_reference = ".$region_id[0];
		$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		$id_nb_erreur = mysqli_fetch_row($sql);

		$query = "SELECT indicateur_ID FROM indicateurs WHERE id_type_indicateur = 2 AND id_element_reference = ".$region_id[0];
		$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		$id_nb_cours = mysqli_fetch_row($sql);


		if ($id_nb_cours == NULL){

			$sql = "INSERT INTO indicateurs (id_type_indicateur, id_element_reference, valeur_sortie) 
					VALUES (2, ".$region_id[0].", 1)";
			$insertion = mysqli_query($bdd, $sql) or die ('Erreur SQL!<br/>'.mysqli_error($bdd));
		}
		else{

			$sql = "UPDATE indicateurs SET valeur_sortie = valeur_sortie + 1 WHERE indicateur_ID = ".$id_nb_cours[0];
			$insertion = mysqli_query($bdd, $sql) or die ('Erreur SQL!<br/>'.mysqli_error($bdd));

		}

		if ($nb_erreur[0] > 0){

			if ($id_nb_erreur == NULL){

			$sql = "INSERT INTO indicateurs (id_type_indicateur, id_element_reference, valeur_sortie) 
					VALUES (1, ".$region_id[0].", 1)";
			$insertion = mysqli_query($bdd, $sql) or die ('Erreur SQL!<br/>'.mysqli_error($bdd));
			}
			else{

			$sql = "UPDATE indicateurs SET valeur_sortie = valeur_sortie + 1 WHERE indicateur_ID = ".$id_nb_erreur[0];
			$insertion = mysqli_query($bdd, $sql) or die ('Erreur SQL!<br/>'.mysqli_error($bdd));

			}
		}


	}


	mysqli_close($bdd);

?>