<?php
	echo "Ouverture de erreurDistance.php<br/>";
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
					$temps_parcours = $real_time_suivant - $real_time;
					$c_ID_suivant = $cours_suivant->{'class_id'};

					
					// On ne vérifie que des cours qui se déroulent max 2h plus tard
					if (($temps_parcours/60) <= 60 && ($temps_parcours/60) >= 0 ){

						$c_teacher_list_suivant = $cours_suivant->{'teacher_list'};
						$c_host_list_suivant = $cours_suivant->{'host_list'};
						$intervenant_list_suivant = array_merge($c_teacher_list_suivant, $c_host_list_suivant);

						$list_commune = array_intersect($intervenant_list, $intervenant_list_suivant);

						if(count($list_commune) != 0){


							$query = "SELECT salle_lat, salle_lon FROM salle WHERE salle_ID = ".$c_class_id;
							$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
							$coordonnees = mysqli_fetch_row($sql);

							$query = "SELECT salle_lat, salle_lon FROM salle WHERE salle_ID = ".$c_class_id_suivant;
							$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
							$coordonnees_suivant = mysqli_fetch_row($sql);

							$r = 6366;
							$lat1 = deg2rad($coordonnees[0]);
							$lon1 = deg2rad($coordonnees[1]);
							$lat2 = deg2rad($coordonnees_suivant[0]);
							$lon2 = deg2rad($coordonnees_suivant[1]);
							$ds= acos(sin($lat1)*sin($lat2)+cos($lat1)*cos($lat2)*cos($lon1-$lon2));

							$distance_parcours = $ds * $r;

							$vitesse_inverse = $temps_parcours / $distance_parcours;

							// Si la vitesse moyenne pour arriver est supérieure à 50 km/h
							// <=> si le temps (en minute) sur la distance (km) < 1.2
							if ($vitesse_inverse <= 1.2){

								
								foreach ($list_commune as $intervenant){

									$query = "SELECT int_prenom, int_nom FROM intervenant WHERE int_ID_intervenant = ".$intervenant;
									$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
									$prenom_nom = mysqli_fetch_row($sql);

									$query = "SELECT salle_nom FROM salle WHERE salle_ID = ".$c_class_id;
									$sql = mysqli_query ($bdd, $query) or die ("Erreur SQL ! </br>".mysqli_error($bdd));
									$nom_salle = mysqli_fetch_row($sql);

									$message = "Attention, ".$prenom_nom[0]." ".$prenom_nom[1]." finit son cours à ".$nom_salle[0]." ".($temps_parcours/60)." minutes avant";
									
									$sql = "INSERT INTO erreurs (id_type_erreur, id_cours_reference, msg_erreur) 
											VALUES (4, ".$c_ID_suivant.", '".$message."')";
									$insertion = mysqli_query($bdd, $sql) or die ('Erreur SQL!<br/>'.mysqli_error($bdd));

									unset($query, $sql, $prenom_nom, $nom_salle, $message, $insertion);

								}
								


							}

							

							
							
							unset($coordonnees, $coordonnees_suivant, $r, $lat1, $lat2, $lon1, $lon2, $ds, $distance_parcours, $vitesse_inverse);
							
						}
						unset($c_teacher_list_suivant, $c_host_list_suivant, $intervenant_list_suivant, $list_commune);
					}
					unset($c_start_suivant, $c_date_suivant, $real_time_suivant, $temps_parcours, $c_ID_suivant);

				}
				unset ($c_class_id_suivant);
			}
			unset($c_ID, $c_date, $c_start, $c_duration, $c_class_id, $c_teacher_list, $c_teacher_list_implode, $c_host_list, $c_host_list_implode, $intervenant_list, $real_time);
		}


	mysqli_close($bdd);
	unset ($chemin, $json_resolution, $parsed_json_resolution);
	
?>