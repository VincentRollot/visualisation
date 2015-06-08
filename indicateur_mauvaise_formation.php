<?php
	//echo "Ouverture de stock_BDD.php<br/>";
	//Connexion à la BDD
		require 'connexion.php';
	
	
	//Insérer les salles : table SALLE
		//Chemin JSON pour récupérer les salles
		//$chemin= getcwd ();
		//echo $chemin;
		/*$json_alimentation = file_get_contents("./AlimentationVF2.json");
		$parsed_json_alimentation = json_decode($json_alimentation);
		
		//On supprime les enregistrements de la table
		mysqli_query($bdd, "DELETE FROM disponibilite") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		mysqli_query($bdd, "DELETE FROM disponibilite_salle") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		mysqli_query($bdd, "DELETE FROM intervenant") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		mysqli_query($bdd, "DELETE FROM intensite_intervenant") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		
		//On remet la BDD à 0
		$sql_zero = "ALTER TABLE disponibilite AUTO_INCREMENT=0";
		mysqli_query($bdd, $sql_zero) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
		$sql_un = "ALTER TABLE disponibilite_salle AUTO_INCREMENT=0";
		mysqli_query($bdd, $sql_un) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
		$sql_un = "ALTER TABLE intervenant AUTO_INCREMENT=0";
		mysqli_query($bdd, $sql_un) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
		$sql_un = "ALTER TABLE intensite_intervenant AUTO_INCREMENT=0";
		mysqli_query($bdd, $sql_un) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
		
		unset ($sql_zero,$sql_un);
		$cpt = 0 ;
		//echo $json_alimentation;	
		//echo json_last_error();
		
		*/
		
		$sql = "SELECT * FROM cours_intervenant";
		$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));		
		echo $sql;
		//echo $insertion;
		$cpt = 1 ;
		
		while ($line = mysqli_fetch_array($insertion)) {
			/*foreach ($line as $col_value) {
				echo $col_value . '<br />';
			}*/
			$id_cours = $line['id_cours'];
			$id_intervenant = $line['id_intervenant'];
			//echo "</br>".$line[$cpt]."</br>";
			
			if($line['is_teacher']==1)
			{
				$sql = "SELECT cours_type FROM cours WHERE cours_id=".$id_cours;
				$cours = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				$intensite = mysqli_fetch_array($cours);
				//echo $intensite[0];
				
				$sql = "SELECT * FROM intensite_intervenant WHERE int_ID=".$id_intervenant." AND class_level=".$intensite[0];
				//$sql = "SELECT * FROM intensite_intervenant WHERE int_ID=".$id_intervenant." AND class_level=".$intensite;
				$liste_intensite_intervenant = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				$prof_autorise=FALSE;
				$jjjjjjjj;
				
				while($prof_autorise==FALSE && $intervenant_intensite = mysqli_fetch_array($liste_intensite_intervenant))
				{
					//echo $intensite_intervenant['class_level'];
					//echo "</br>".$intervenant_intensite['int_ID'];
					//echo "</br>le niveau que peut realiser l'intervenant est ".$intervenant_intensite['class_level']." ";
					//echo "et le niveau du cours est".$intensite[0];
					if($intervenant_intensite['class_level']==$intensite[0])
					{
						$prof_autorise=TRUE;
						//echo " donc c 'est ok";
						
					}
					$jjjjjjjj=$intervenant_intensite['class_level'];
					//echo $intensite[0];
				}
				//echo $prof_autorise." ici 	";
				if($prof_autorise==FALSE)
				{
					echo "</br> ERREUR DETECTEE !!!! Un professeur n'est pas autorisé à donner cours !";
					//echo " l'intensite est ".$jjjjjjjj;
					//echo $line['int_prenom'];
					echo " l'id cours_intervenant est ".$cpt." et l'identifiant du prof est ".$id_intervenant;
					
					//Recupération du type d'erreur
					$sql = "SELECT id_erreur FROM libelle_erreurs WHERE libelle='mauvaise_formation'";
					$id_erreur = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
					$type_erreur = mysqli_fetch_array($id_erreur);
					
					//Récupération du nom/prénom de la personne
					$sql = "SELECT int_prenom, int_nom FROM intervenant WHERE int_ID_intervenant=".$id_intervenant;
					$info_intervenant = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
					$nom_prenom_intervenant = mysqli_fetch_array($info_intervenant);
					
					//Récupération du type de cours
					$sql = "SELECT description FROM intensite WHERE class_level=".$intensite[0];
					$description = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
					$mauvaise_intensite = mysqli_fetch_array($description);
					
					//Insertion de l'erreur dans la bdd
					$sql = "INSERT INTO erreurs VALUES('',".$type_erreur[0]." , ".$id_cours.", '".$nom_prenom_intervenant[0]." ".$nom_prenom_intervenant[1]." ne peut donner un cours de type ".$mauvaise_intensite[0]." ')";				
					echo "</br>".$sql;
					$ajout_erreur = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				}
				//mysqli_fetch_array($intensite_intervenant);
				//$prof_autorise=FALSE;
				//echo mysqli_fetch_array($intensite_intervenant);

				
			}
			//echo "</br>On a finit ce professeur</br>";
			//echo $id_cours;
			$cpt = $cpt+1 ;
			
		}

		
		

	//Arrêt de la connexion à la BDD
	mysqli_close($bdd);
	
	
?>