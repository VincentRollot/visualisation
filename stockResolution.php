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
		
		//On supprime les enregistrements de la table
		mysqli_query($bdd, "DELETE FROM cours") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		mysqli_query($bdd, "DELETE FROM cours_intervenant") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		
		//On remet la BDD à 0
		
		$sql_un = "ALTER TABLE cours_intervenant AUTO_INCREMENT=0";
		mysqli_query($bdd, $sql_un) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
		
		unset ($sql_zero,$sql_un);
		$cpt = 1 ;
		//echo $json_resolution;	
		
		//echo json_last_error();
		
		//echo $json_resolution;
		
		foreach ($parsed_json_resolution as $j_planning){
			
			//Conversion des caractères spéciaux avant insertion dans la BDD
				//$t_users = $parsed_json_resolution[$cpt]->{'user'};
				//$c_users = $parsed_json_resolution[$cpt]->{'user'};
				$c_ID = $j_planning->{'class_id'};
				$c_date = $j_planning->{'class_date'};
				echo $c_date ."    ";
				$c_day = $j_planning->{'class_dayofweek'};
				$c_start = $j_planning->{'class_starttime'}.":00";
				$c_duration = $j_planning->{'class_duration'};
				$c_capacity = $j_planning->{'class_capacity'};
				$c_intensity = $j_planning->{'class_level'};
				$c_class_id = $j_planning->{'classroom_id'};
				$c_nb_teacher = $j_planning->{'nb_teacher'};
				$c_teacher_list = $j_planning->{'teacher_list'};
				$c_host_list = $j_planning->{'host_list'};
				
				$sql = "INSERT INTO cours (cours_ID, cours_salle_ID, cours_type, cours_date, cours_joursemaine, cours_heuredebut, cours_duree, cours_nb_prof, cours_nb_hote) 
				VALUES(".$c_ID." ,".$c_class_id." ,".intval($c_intensity)." ,'".$c_date."' ,".intval($c_day)." , '".$c_start."' , ".$c_duration." , ".$c_nb_teacher[0]." , ".$c_nb_teacher[1].")";				
				
				$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				
				
				
				
				for( $i=0; $i<count($c_teacher_list) ; $i++)
				{
					$sql = "INSERT INTO cours_intervenant (id_cours, id_intervenant, is_teacher) 
					VALUES(".$c_ID." ,".intval($c_teacher_list[$i]).", 1)";				
				//	echo $sql;
					$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				}
				
				for( $i=0; $i<count($c_host_list) ; $i++)
				{
					$sql = "INSERT INTO cours_intervenant (id_cours, id_intervenant, is_teacher) 
					VALUES(".$c_ID." ,".intval($c_host_list[$i]).", 0)";				
				//	echo $sql;
					$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				}
				
				
				$cpt = $cpt +1;
			
			
		}	
	
	//Arrêt de la connexion à la BDD
	mysqli_close($bdd);
	
	
?>