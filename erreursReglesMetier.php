<?php
	
	echo "Ouverture de erreurRegleMetier.php<br/>";
	//Connexion à la BDD
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

		$c_start = $cours->{'class_starttime'}.":00";
		$c_date = $cours->{'class_date'};
		$c_duration = $cours->{'class_duration'};
		$time_fin = strtotime($c_date." ".$c_start) + $c_duration * 60;
		$time_debut = strtotime($c_date." ".$c_start);

		foreach ($parsed_json_resolution as $cours_suivant){

			$c_start_suivant = $cours_suivant->{'class_starttime'}.":00";
			$c_date_suivant = $cours_suivant->{'class_date'};
			$c_duration_suivant = $cours_suivant->{'class_duration'};
			$time_debut_suivant = strtotime($c_date_suivant." ".$c_start_suivant);
			$c_class_id = $cours->{'classroom_id'};
			$c_class_id_suivant = $cours_suivant->{'classroom_id'};
			//On vérifie les cours qui se déroulent en même temps
			$c_intensity = $cours->{'class_level'};
			$c_intensity_suivant = $cours_suivant->{'class_level'};
			if ($time_debut_suivant < $time_fin && $time_debut_suivant >= $time_debut && $c_class_id != $c_class_id_suivant){
				
				$c_teacher_list = $cours->{'teacher_list'};
				$c_host_list = $cours->{'host_list'};
				$intervenant_list = array_merge($c_teacher_list, $c_host_list);

				$c_teacher_list_suivant = $cours_suivant->{'teacher_list'};
				$c_host_list_suivant = $cours_suivant->{'host_list'};
				$intervenant_list_suivant = array_merge($c_teacher_list_suivant, $c_host_list_suivant);

				$list_commune = array_intersect($intervenant_list, $intervenant_list_suivant);

				if(count($list_commune) != 0){

					
					$c_ID_suivant = $cours_suivant->{'class_id'};
					$c_ID = $cours->{'class_id'};

					foreach ($list_commune as $intervenant){

						$query = "SELECT int_prenom, int_nom FROM intervenant WHERE int_ID_intervenant = ".$intervenant;
						$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
						$prenom_nom = mysqli_fetch_row($sql);

						$query = "SELECT salle_nom FROM salle WHERE salle_ID = ".$c_class_id;
						$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
						$nom_salle = mysqli_fetch_row($sql);

						$query = "SELECT salle_nom FROM salle WHERE salle_ID = ".$c_class_id_suivant;
						$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
						$nom_salle_suivant = mysqli_fetch_row($sql);

						$message = "Attention, ".$prenom_nom[0]." ".$prenom_nom[1]." donne cours en même temps à ".$nom_salle[0];

						$sql = "INSERT INTO erreurs (id_type_erreur, id_cours_reference, msg_erreur) 
								VALUES (5, ".$c_ID_suivant.", '".$message."')";
						$insertion = mysqli_query($bdd, $sql) or die ('Erreur SQL!<br/>'.mysqli_error($bdd));
									



					}


				}

			}
			elseif ((($time_debut_suivant - $time_fin) / 60) <= 60 && $time_debut_suivant >= $time_fin && $c_intensity != 50 && $c_intensity != 60 && $c_intensity != 96 && $c_intensity_suivant != 50 && $c_intensity_suivant != 60 && $c_intensity_suivant != 96){

				$c_teacher_list = $cours->{'teacher_list'};
				$c_host_list = $cours->{'host_list'};
				$intervenant_list = array_merge($c_teacher_list, $c_host_list);

				$c_teacher_list_suivant = $cours_suivant->{'teacher_list'};
				$c_host_list_suivant = $cours_suivant->{'host_list'};
				$intervenant_list_suivant = array_merge($c_teacher_list_suivant, $c_host_list_suivant);

				$list_commune = array_intersect($intervenant_list, $intervenant_list_suivant);

				if(count($list_commune) != 0){

					
					$c_ID_suivant = $cours_suivant->{'class_id'};
					$c_ID = $cours->{'class_id'};

					foreach ($list_commune as $intervenant){

						$query = "SELECT int_prenom, int_nom FROM intervenant WHERE int_ID_intervenant = ".$intervenant;
						$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
						$prenom_nom = mysqli_fetch_row($sql);

						$query = "SELECT salle_nom FROM salle WHERE salle_ID = ".$c_class_id;
						$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
						$nom_salle = mysqli_fetch_row($sql);

						$query = "SELECT description FROM intensite WHERE class_level = ".$c_intensity;
						$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
						$intensite = mysqli_fetch_row($sql);

						$query = "SELECT description FROM intensite WHERE class_level = ".$c_intensity_suivant;
						$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
						$intensite_suivant = mysqli_fetch_row($sql);

						$message = "Attention, ".$prenom_nom[0]." ".$prenom_nom[1]." enchaine un cours d''intensité ".$intensite[0]." à ".$nom_salle[0]." avec un cours d''intensité ".$intensite_suivant[0];
						$sql = "INSERT INTO erreurs (id_type_erreur, id_cours_reference, msg_erreur) 
								VALUES (6, ".$c_ID_suivant.", '".$message."')";
						$insertion = mysqli_query($bdd, $sql) or die ('Erreur SQL!<br/>'.mysqli_error($bdd));
									



					}


				}
			}

		}
		

	}

	mysqli_close($bdd);
?>