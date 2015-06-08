<?php
	echo "Ouverture de stock_BDD.php<br/>";
	//Connexion à la BDD
		require 'connexion.php';	
	
	//Insérer les région : table region
		//Chemin JSON pour récupérer les régions
		$json_region = file_get_contents("http://ws.gymsuedoise.com/api/v1/region&apikey=t494hmF9m74J665J&country=FR");
		$parsed_json_region = json_decode($json_region);
		
		//On supprime les enregistrements de la table
		mysqli_query($bdd, "DELETE FROM region") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		mysqli_query($bdd, "DELETE FROM region_salle") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		
		//On remet la BDD à 0
		$sql_zero = "ALTER TABLE region_salle AUTO_INCREMENT=0";
		
		
		unset ($sql_zero);
		
		//Innitialisation du compteur qui va parcourir le tableau des régions
			$cpt = 0;
			
		//$sql = "SELECT region_liste_salle FROM region WHERE region_ID_v1=1";
		//$req = mysqli_query($bdd, $sql) or die('Erreur SQL !<br/>'.mysqli_error($bdd));
		
		foreach ($parsed_json_region as $j_region){			
			//Conversion des caractères spéciaux avant insertion dans la BDD
				$r_ID = $j_region->{'region_id'};
				$r_nom = mysqli_real_escape_string($bdd, $j_region->{'region_name'});
				$r_pays = mysqli_real_escape_string($bdd, $j_region->{'region_country_code'});
				$r_lat = $j_region->{'region_gps_lat'};
				$r_lon = $j_region->{'region_gps_lon'};
				
				$sql = "INSERT INTO region (region_ID, region_nom, region_pays, region_lat, region_lon) VALUES(".$r_ID." ,'".$r_nom."','".$r_pays."', ".$r_lat.", ".$r_lon.")";
				$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
			//Récupérer la liste des salles de cette région	
				//On utilise l'API de la FFGS pour obtenir les détails d'une région
				$json_region_detail = file_get_contents("http://ws.gymsuedoise.com/api/v1/region/".$r_ID."&apikey=t494hmF9m74J665J&country=FR");
				$parsed_json_region_detail = json_decode($json_region_detail);
				//var_dump(json_decode($json_region_detail));				
				$r_liste_salle = $parsed_json_region_detail->{'classroom_list'};//Récupération du tableau de salles d'une région
				
				//$i = 0;
				
				if (($r_ID != -1)&&($r_ID != 60)&&($r_ID != 53)){
					foreach ($r_liste_salle as $r_salle){
						echo $r_salle;

						echo '<br/>';
						$sql_region = "INSERT INTO region_salle (salle_ID, region_ID) VALUES(".$r_salle.", ".$r_ID.")";
						$insertion = mysqli_query($bdd, $sql_region) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
					}
				}
				
				
				//On serialise la liste des salles d'une région pour la stocker dans la BDD
				//$r_serialize = serialize($r_liste_salle);		
				
			//Insertion dans la BDD	des données sur les régions
				
				
			//On libère toutes les variables temporaires
				unset($sql, $insertion, $r_ID, $r_nom, $r_adresse, $r_cp, $r_ville, $r_pays, $r_lat, $r_lon, $r_serialize, $r_liste_salle);
				
			//On incrément le compteur pour accéder aux informations de la région suivante
				$cpt = $cpt + 1;
			
		}	
	
	//Arrêt de la connexion à la BDD
	mysqli_close($bdd);
?>