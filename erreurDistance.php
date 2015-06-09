<?php
	//echo "Ouverture de stock_BDD.php<br/>";
	//Connexion à la BDD
		require 'connexion.php';
	
	
	//Insérer les salles : table SALLE
		//Chemin JSON pour récupérer les salles
		$chemin= getcwd ();
		
		//echo $chemin;
		$json_resolution = file_get_contents("./planningResoluV2.json");
		$parsed_json_resolution = json_decode($json_resolution);


		//Boucle sur les cours du JSON
		foreach ($parsed_json_resolution as $cours){


			$c_ID = $cours->{'class_id'};
			$c_date = $cours->{'class_date'};
			$c_start = $cours->{'class_starttime'}.":00";
			$c_duration = $cours->{'class_duration'};
			$c_class_id = $cours->{'classroom_id'};
			$c_teacher_list = $cours->{'teacher_list'};
			$c_teacher_list_implode = implode(",", $c_teacher_list);
			$c_host_list = $cours->{'host_list'};
			$c_host_list_implode = implode(",", $c_host_list);
			$intervenant_list = array_merge($c_teacher_list, $c_host_list);

			$real_time = strtotime($c_date." ".$c_start) + $c_duration * 60;
			
			//On reboucle sur tous les cours pour trouver un éventuel cours suivant dans une autre salle
			foreach($parsed_json_resolution as $cours_suivant){

				$c_class_id_suivant = $cours_suivant->{'classroom_id'};


				// le cours suivant doit être dans une autre salle, donc l'id doit être différent
				if ($c_class_id_suivant != $c_class_id){

					$c_start_suivant = $cours_suivant->{'class_starttime'}.":00";
					$c_date_suivant = $cours_suivant->{'class_date'};

					$real_time_suivant = strtotime($c_date_suivant." ".$c_start_suivant);
					$temps_entre = $real_time_suivant - $real_time;
					$c_ID_suivant = $cours_suivant->{'class_id'};

					
					
					// On ne vérifie que des cours qui se déroulent max 2h plus tard
					if ((($real_time_suivant - $real_time)/60) <= 120 && (($real_time_suivant - $real_time)/60) >= 0 ){

						$c_teacher_list_suivant = $cours_suivant->{'teacher_list'};
						$c_host_list_suivant = $cours_suivant->{'host_list'};
						$intervenant_list_suivant = array_merge($c_teacher_list_suivant, $c_host_list_suivant);

						$list_commune = array_intersect($intervenant_list, $intervenant_list_suivant);

						if(count($list_commune) != 0){

							if ((($real_time_suivant - $real_time)/60) == 0 ){

								echo "en fait je suis con";
							}

							else{

							
							
							echo "bitch";
							$query = "SELECT salle_lat, salle_lon FROM salle WHERE salle_ID = ".$c_class_id;
							$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
							$coordonnees = mysqli_fetch_row($sql);

							$query = "SELECT salle_lat, salle_lon FROM salle WHERE salle_ID = ".$c_class_id_suivant;
							$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
							$coordonnees_suivant = mysqli_fetch_row($sql);
							
							echo $c_ID."  ".$c_ID_suivant."  ".implode(",", $list_commune)."  ".($real_time_suivant - $real_time)/60;
							echo "</br>";

							$vitesse = sqrt(floatval($coordonnees_suivant));

							}
							
						}

					}


				}
			}
		}


	mysqli_close($bdd);
	
?>