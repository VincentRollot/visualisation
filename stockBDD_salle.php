<?php
	echo "Ouverture de stockBDD_salle.php<br/>";
	//Connexion à la BDD
		require 'connexion.php';
	
	//Insérer les salles : table SALLE
		//Chemin JSON pour récupérer les salles
		$json_salle = file_get_contents("http://ws.gymsuedoise.com/api/v1/classroom&apikey=t494hmF9m74J665J&country=FR");
		$parsed_json_salle = json_decode($json_salle);
		
		//On supprime les enregistrements de la table
		mysqli_query($bdd, "DELETE FROM salle") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		
		//On remet la BDD à 0
		$sql_zero = "ALTER TABLE salle AUTO_INCREMENT=0";
		mysqli_query($bdd, $sql_zero) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
		
		unset ($sql_zero);
		$cpt = 1 ;
		
		foreach ($parsed_json_salle as $j_salle){
			
			//Tant que l'objet avec un ID = cpt est vide, on incrémente le compteur
			while (empty($parsed_json_salle->{$cpt}) == true)
			{
				echo "Aucune salle ne correspond à l'ID ".$cpt.'<br/>';
				$cpt = $cpt +1;
				
			}
			
			//Conversion des caractères spéciaux avant insertion dans la BDD
				$s_ID = $parsed_json_salle->{$cpt}->{'classroom_id'};
				$s_nom = mysqli_real_escape_string($bdd, $parsed_json_salle->{$s_ID}->{'classroom_name'});
				$s_adresse = mysqli_real_escape_string($bdd, $parsed_json_salle->{$s_ID}->{'classroom_address'});
				$s_cp = $parsed_json_salle->{$s_ID}->{'classroom_zip'};
				$s_ville = mysqli_real_escape_string($bdd, $parsed_json_salle->{$s_ID}->{'classroom_city'});
				$s_pays = $parsed_json_salle->{$s_ID}->{'classroom_country_code'};
				$s_lat = $parsed_json_salle->{$s_ID}->{'classroom_gps_lat'};
				$s_lon = $parsed_json_salle->{$s_ID}->{'classroom_gps_lon'};
				$s_cap = $parsed_json_salle->{$s_ID}->{'classroom_capacity'};
				
				
			//Insertion dans la BDD	
				$sql ="INSERT INTO salle VALUES('',".$s_ID." ,'".$s_nom."','".$s_adresse."', ".$s_cp.", '".$s_ville."', '".$s_pays."', ".$s_lat.", ".$s_lon.", ".$s_cap.")";
				$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				unset($sql, $insertion, $s_ID, $s_nom, $s_adresse, $s_cp, $s_ville, $s_pays, $s_lat, $s_lon, $s_cap);

			//Incrémenter pour passer à la salle suivante
				$cpt = $cpt +1;
			
			
		}	
	
	//Arrêt de la connexion à la BDD
		mysqli_close($bdd);
?>