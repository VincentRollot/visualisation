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
		$sql_zero = "ALTER TABLE cours AUTO_INCREMENT=0";
		mysqli_query($bdd, $sql_zero) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
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
				$c_ID = $parsed_json_resolution->{$cpt}->{'class_id'};
				$c_date = $parsed_json_resolution->{$cpt}->{'class_date'};
				$c_day = $parsed_json_resolution->{$cpt}->{'class_dayofweek'};
				$c_start = $parsed_json_resolution->{$cpt}->{'class_starttime'};
				$c_duration = $parsed_json_resolution->{$cpt}->{'class_duration'};
				$c_capacity = $parsed_json_resolution->{$cpt}->{'class_capacity'};
				$c_intensity = $parsed_json_resolution->{$cpt}->{'class_level'};
				$c_class_id = $parsed_json_resolution->{$cpt}->{'classroom_id'};
				$c_nb_teacher = $parsed_json_resolution->{$cpt}->{'nb_teacher'};
				$c_teacher_list = $parsed_json_resolution->{$cpt}->{'teacher_list'};
				$c_host_list = $parsed_json_resolution->{$cpt}->{'host_list'};
				
				$sql = "INSERT INTO cours VALUES(".$c_ID." ,".intval($c_intensity)." ,'".$c_date."' ,".intval($c_day)." , '".$c_start."' , ".$c_duration." , ".$c_nb_teacher[0]." , ".$c_nb_teacher[1].")";				
				echo $sql;
				$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				
				
				
				
				for( $i=0; $i<count($c_teacher_list) ; $i++)
				{
					$sql = "INSERT INTO cours_intervenant VALUES('',".$c_ID." ,".intval($c_teacher_list[$i]).", 1)";				
				//	echo $sql;
					$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				}
				
				for( $i=0; $i<count($c_host_list) ; $i++)
				{
					$sql = "INSERT INTO cours_intervenant VALUES('',".$c_ID." ,".intval($c_host_list[$i]).", 0)";				
				//	echo $sql;
					$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				}
				
				
				$cpt = $cpt +1;
			
			
		}	
	
	//Arrêt de la connexion à la BDD
	mysqli_close($bdd);
	
	
?>