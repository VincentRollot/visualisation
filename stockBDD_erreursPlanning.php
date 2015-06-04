 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	
	echo "</br> Connexion à la BDD";
	
	require 'connexion.php';

	//Récupération du JSON Résolution
	$json_resolution = file_get_contents("C:/Users/Kouinou/Desktop/Visualisation1/visualisation/planningResoluV2.json");
	$parsed_json_resolution = json_decode($json_resolution);

	//Suppression des éléments de la table des erreurs

	
	mysqli_query($bdd, "SET NAMES 'utf8'") or die ('Erreur SQL ! '.mysqli_error($bdd));

	mysqli_query($bdd, "DELETE FROM erreurs") or die ('Erreur SQL ! '.mysqli_error($bdd));

	//On remet la BDD à 0
	$sql_zero = "ALTER TABLE erreurs AUTO_INCREMENT=0";
	mysqli_query($bdd, $sql_zero) or die ('Erreur SQL!'.mysqli_error($bdd));

	unset ($sql_zero);
	$cpt = 1;

	foreach ($parsed_json_resolution as $j_salle){

		while (empty($parsed_json_resolution->{$cpt}) == true){
			
			echo "Aucune salle n'a l'ID </br>" .$cpt ;
			$cpt = $cpt + 1;
		}
		
		//Récupération des tableaux de listes d'intervenants
		$lst_nb_intervenants = $parsed_json_resolution->{$cpt}->{'nb_teacher'};
		$lst_professeurs = $parsed_json_resolution->{$cpt}->{'teacher_list'};
		$lst_hotes = $parsed_json_resolution->{$cpt}->{'host_list'};
		$id_cours = $parsed_json_resolution->{$cpt}->{'class_id'};

		//Vérification du nombre de profs/intervenants
		if (count($lst_professeurs) < $lst_nb_intervenants[0])
		{
			
			
			$nb_manquant = $lst_nb_intervenants[0] - count($lst_professeurs);
			$msg_erreur = mysqli_real_escape_string($bdd, "Il manque " .$nb_manquant. " professeurs à ce cours");
			
			$sql = "INSERT INTO erreurs VALUES('',1 ,".$id_cours.",'".$msg_erreur."')";
			$insertion = mysqli_query($bdd, $sql) or die ('Erreur SQL!<br/>'.mysqli_error($bdd));
			unset($nb_manquant, $sql, $insertion);
			echo "</br>Pas assez de profs pour le cours " .$cpt;
		}

		if (count($lst_hotes) < $lst_nb_intervenants[1])
		{
			echo "</br>Pas assez d'hotes pour le cours" .$cpt;
			
			$nb_manquant = $lst_nb_intervenants[1] - count($lst_hotes);
			$msg_erreur = mysqli_real_escape_string($bdd, "Il manque ".$nb_manquant." hotes à ce cours");
			$sql = "INSERT INTO erreurs VALUES('',1,".$id_cours.",'$msg_erreur')";
			$insertion = mysqli_query($bdd, $sql) or die ('Erreur SQL!<br/>'.mysqli_error($bdd));
			unset($nb_manquant, $sql, $insertion);
			echo "</br>Pas assez d'hotes pour le cours" .$cpt;
		}

		$cpt = $cpt + 1;
	}

	//arrêt de la connexion à la bdd
	mysqli_close($bdd);
?>
