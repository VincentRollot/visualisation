<?php
	//echo "Ouverture de stock_BDD.php<br/>";
	//Connexion à la BDD
		echo "Ouverture de stockAlimentation.php<br/>";
		require 'connexion.php';
	
	
	//Insérer les salles : table SALLE
		//Chemin JSON pour récupérer les salles
		$chemin= getcwd ();
		
		//echo $chemin;
		$json_alimentation = file_get_contents("./AlimentationVF2.json");
		$parsed_json_alimentation = json_decode($json_alimentation);
		echo $parsed_json_alimentation;
		
		//On supprime les enregistrements de la table
		
		
		
		$cpt = 0 ;
		//echo $json_alimentation;	
		//echo json_last_error();
		
		
		foreach ($parsed_json_alimentation as $j_disponibilite){
			
			//Conversion des caractères spéciaux avant insertion dans la BDD
				//$t_users = $parsed_json_alimentation[$cpt]->{'user'};
				$t_users = $j_disponibilite->{'user'};
				$t_ID = $t_users->{'id'};
				//echo $t_ID;
				$t_mail = mysqli_real_escape_string($bdd, $t_users->{'mail'});
				$t_name = mysqli_real_escape_string($bdd, $t_users->{'name'});
				$t_firstname = mysqli_real_escape_string($bdd, $t_users->{'firstname'});
				$t_intensity = $t_users->{'intensity'};
				
				if($t_users->{'staff_is_teacher'}=="")
				{
					$t_staff_is_teacher = 0;
				}
				
				else
				{
					$t_staff_is_teacher = 1;
				}
				
				//$t_staff_is_teacher = $t_users->{'staff_is_teacher'};
				//$t_staff_is_teacher = FALSE;
				if($t_users->{'staff_is_host'}=="")
				{
					$t_staff_is_host = 0;
				}
				else
				{
					$t_staff_is_host = 1;
				}
				
				//$t_staff_is_host =  $t_users->{'staff_is_host'};
				//$t_staff_is_host = FALSE;
				$t_weeks = $j_disponibilite->{'weeks'};
				
				//echo "</br></bt>\n/n";
				//echo count($t_weeks);
				//echo $t_weeks[0]->{'numberWeek'}."</br>";
				//echo "</br></bt>staff_is_host".$t_staff_is_host."</br></bt>";
				$sql = "INSERT INTO intervenant (int_ID_intervenant, int_mail, int_nom, int_prenom, int_is_teacher, int_is_host)
				VALUES(".$t_ID." ,'".$t_mail."' ,'".$t_name."','".$t_firstname."', ".$t_staff_is_teacher.", ".$t_staff_is_host." )";
				
				//echo $sql;
				
				$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				
				
				for( $i=0; $i<count($t_intensity) ; $i++)
				{
					$sql = "INSERT INTO intensite_intervenant (id_intervenant, class_level) VALUES (".$t_ID." ,".$t_intensity[$i]." )";				
				//	echo $sql;
					$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
					
				}
				
				
				
				
				
				
				for( $a=0; $a<count($t_weeks); $a++)
				{
					//$sql = "INSERT INTO disponibilite VALUES('',".$t_ID." ,'".$t_weeks[$a]->{'numberWeek'};//." ,'".$t_weeks[a]->{'availability_date'}."','".$t_weeks[$a]->{'availability_dayofweek'}."', ".$t_weeks[$a]->{'availability_starttime'}.", '".$t_weeks[$a]->{'availability_duration'}."', '".$t_weeks[$a]->{'availability_duration'}.", '".$t_weeks[$a]->{'availability_duration'}.")";
					
					for( $i=0; $i<count($t_weeks[$a]->{'availabilities'}) ; $i++)
					{
						
						$time = ($t_weeks[$a]->{'availabilities'}[$i]->{'availability_starttime'}).":00";
						$sql = "INSERT INTO disponibilite (disponibilite_ID_intervenant, disponibilite_num_semaine, disponibilite_date, disponibilite_joursemaine, disponibilite_heuredebut, disponibilite_duree)
						VALUES(".$t_ID." ,".$t_weeks[$a]->{'numberWeek'}." ,'".$t_weeks[$a]->{'availabilities'}[$i]->{'availability_date'}."','".$t_weeks[$a]->{'availabilities'}[$i]->{'availability_dayofweek'}."', '".$time."', ".$t_weeks[$a]->{'availabilities'}[$i]->{'availability_duration'}." )";
						
						//echo $sql;
						//echo "</br> Le nombre de disponibilite est ".count($t_weeks[$a]->{'availabilities'})."</br>";
						$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
						$id_ajout=($bdd->insert_id);
						for( $b=0; $b<count($t_weeks[$a]->{'places'});  $b++)
						{
							$sql = "INSERT INTO disponibilite_salle (disponibilite_ID, id_salle)
							VALUES(".$id_ajout." ,".$t_weeks[$a]->{'places'}[$b].")";
							$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
						}
						
					}
					//$sql = "INSERT INTO disponibilite VALUES('',".$t_ID." ,'".$weeks[a]->{'numberWeek'}." ,'".$weeks[a]->{'availability_date'}."','".$weeks[$a]->{'availability_dayofweek'}."', ".$weeks[$a]->{'availability_starttime'}.", '".$weeks[$a]->{'availability_duration'}."', '".$weeks[$a]->{'availability_duration'}.")";
					
					$sql = "INSERT INTO intervenant_disponibilite_semaine (int_ID_intervenant, numero_semaine, lessonsMax) 
					VALUES(".$t_ID." ,".$t_weeks[$a]->{'numberWeek'}." ,".$t_weeks[$a]->{'lessonsMax'}." )";
				
					
					$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
					
					
					//echo "</br></br>".count($t_weeks[$a]->{'places'})."</br></br>";
					//echo ($bdd->insert_id);
					
					
					
					//$sql = "INSERT INTO disponibilite VALUES('',".$t_ID.")";
					
					
					
					
				}
				unset($sql, $insertion, $t_ID, $t_name, $t_firstname, $t_staff_is_host, $t_staff_is_teacher, $t_weeks, $t_ID, $t_intensity, $t_mail);
				$cpt = $cpt +1;
			
			
		}	
	
	//Arrêt de la connexion à la BDD
	mysqli_close($bdd);
	
	
?>