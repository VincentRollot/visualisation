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
		
		$sql = "SELECT * FROM intervenant";
		$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));		
		echo $sql;
		//echo $insertion;
		$cpt = 1 ;
		
		while ($line = mysqli_fetch_array($insertion)) {
			
			for($i=0;$i<=53;$i++)
			{
				//$tableau_semaine[$i][0]=$i;
				//$tableau_semaine[$i][0]=$i;
				$tableau_semaine[$i]=0;
			
			}
			
			
			
			//$table_semaine
			
			/*foreach ($line as $col_value) {
				echo $col_value . '<br />';
			}*/
			//$id_cours = $line['id_cours'];
			$id_intervenant = $line['int_ID_intervenant'];
			//echo "</br>".$line[$cpt]."</br>";
			echo "</br>".$id_intervenant."</br>";
			
			
			$sql = "SELECT * FROM cours_intervenant WHERE id_intervenant=".$id_intervenant;
			$cours = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
			$numero_semaine=1;
			$nombre_de_cours_semaine=0;
			$fin_semaine=FALSE;
			//$intensite = mysqli_fetch_array($cours);
			while ($cours_prof = mysqli_fetch_array($cours)) {
				//$nombre_de_cours_semaine=0;
				
				
				//echo " ".$cours_prof['id_cours'];
				//echo $cours_prof['id_cours'];
				
				$sql = "SELECT * FROM cours WHERE cours_ID=".$cours_prof['id_cours'];
				$info_cours = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				while ($infos_cours = mysqli_fetch_array($info_cours)) {
					//echo " ".$tableau_semaine[intval(date("W", strtotime($infos_cours['cours_date'])))];
					$tableau_semaine[intval(date("W", strtotime($infos_cours['cours_date'])))]=$tableau_semaine[intval(date("W", strtotime($infos_cours['cours_date'])))]+1;
					//$tableau_semaine[intval(date("W", strtotime($infos_cours['cours_date'])))][0]=$;
					//echo " ".$infos_cours['cours_date'];
					/*$sql = "SELECT * FROM disponibilite WHERE disponibilite_ID_intervenant=".$id_intervenant." AND disponibilite_date='".$infos_cours['cours_date']."'";
					$disponibilite_ok=FALSE;
					$disponibilite_prof = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
					//echo "  id ".$id_intervenant." dispo le ".$infos_cours['cours_date'];
					while ($disponibilite_jour = mysqli_fetch_array($disponibilite_prof)) {
						//echo "  AAAA";
						//echo "date : ".$disponibilite_jour['disponibilite_date']." semaine :".date("W", strtotime($disponibilite_jour['disponibilite_date']));
						echo " semaine :".date("W", strtotime($disponibilite_jour['disponibilite_date']));
						
						//ON VEUT VERIFIER L HORAIRE 
						
						
					}
					*/
				}
				
				/*if(date("W", strtotime($intensite['disponibilite_date']))==$numero_semaine)
				{
					$nombre_de_cours_semaine=$nombre_de_cours_semaine+1;
				}
				else if(date("W", strtotime($intensite['disponibilite_date']))>$numero_semaine)
				{
					$sql = "SELECT * FROM cours_intervenant WHERE numero_semaine=".$numero_semaine." AND ";
					$sql = "INSERT INTO intervenant_disponibilite_semaine VALUES('',".$type_erreur[0]." , ".$id_cours.", '".$nom_prenom_intervenant[0]." ".$nom_prenom_intervenant[1]." ne peut donner un cours de type ".$mauvaise_intensite[0]." ')";				
					$numero_semaine=$numero_semaine+1;
					
				}
				*/
				//echo " ".$intensite['disponibilite_date']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				//echo "date :".$intensite['disponibilite_date']." donc semaine ".date("W", strtotime($intensite['disponibilite_date']))."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				/*$calendrier=date_parse($intensite['disponibilite_date']);
				
				echo $calendrier;
				
				for($i=0;$i<count($calendrier);$i++)
				{
					echo  $calendrier[$i];
				}*/
				//echo " ".date("W",$intensite['disponibilite_date'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				//date("W", mktime(0,0,0,$month,$day,$year));
			}
			for($i=0;$i<=53;$i++)
			{
				$sql = "SELECT * FROM intervenant_disponibilite_semaine WHERE int_ID_intervenant=".$id_intervenant." AND numero_semaine=".$i;
				$info_lessonmax = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				while ($info_semaine = mysqli_fetch_array($info_lessonmax)) {
					//echo " ".$info_semaine['lessonsMax'];
					$sql = "INSERT INTO indicateurs VALUES('' , 2 , ".$info_semaine['dispo_semaine_ID']." , ".$tableau_semaine[$i].")";				
					//$sql = "INSERT INTO indicateurs VALUES('' , 2 , ".$info_semaine['numero_semaine']." , ".$tableau_semaine[$i].")";				
					//$sql = "INSERT INTO indicateurs VALUES('' , 2 , ".$info_semaine['lessonsMax']." , ".$tableau_semaine[$i].")";				
					$infos_cours = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				}
			}
			
			/*for( $i=0;$i<count($intensite);$i++)
			{
				//echo $intensite[$i]['disponibilite_date'];
				
			}*/
			/*if($line['is_teacher']==1)
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
					echo "</br>aa".$intervenant_intensite['class_level']." ";
					echo $intensite[0];
					if($intervenant_intensite['class_level']==$intensite[0])
					{
						$prof_autorise=TRUE;
						echo " donc c 'est ok";
						
					}
					$jjjjjjjj=$intervenant_intensite['int_ID'];
					//echo $intensite[0];
				}
				echo $prof_autorise." ici 	";
				if($prof_autorise==FALSE)
				{
					echo "</br>Un professeur n'est pas autorisé à donner cours !";
					echo $jjjjjjjj;
					//echo $line['int_prenom'];
					echo $cpt." et le prof est".$id_intervenant;
					
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
				
			}
			*/
			
			//echo "</br>On a finit ce professeur</br>";
			//echo $id_cours;
			$cpt = $cpt+1 ;
			
		}
		
		
		$sql = "SELECT * FROM indicateurs WHERE id_type_indicateur=2";
		$info_lessonmax = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
		while ($info_semaine = mysqli_fetch_array($info_lessonmax)) {
			//$info_semaine['id_cours_reference']
			//echo " ".$info_semaine['id_element_reference'];
			$sql = "SELECT * FROM intervenant_disponibilite_semaine WHERE dispo_semaine_ID=".$info_semaine['id_element_reference'];
			$valeur_max = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
			while ($lessonsMax = mysqli_fetch_array($valeur_max)) {
				//echo " ".$lessonsMax['lessonsMax'];
				if($lessonsMax['lessonsMax']<$info_semaine['valeur_sortie'])
				{
					echo "</br>On a trouve un problème ! Le professeur id : ".$lessonsMax['int_ID_intervenant']." souhaite faire maximum ".$lessonsMax['lessonsMax']." et il fait ".$info_semaine['valeur_sortie']." cours la semaine ".$lessonsMax['numero_semaine'];
				}
				
			}
			
		}
		
		
		
		
		
		/*foreach ($insertion as $j_disponibilite){
			echo $insertion->{$cpt}->{'id'};
			$cpt=$cpt+1;
			echo $cpt;
		}*/
		
		
		
		/*foreach ($parsed_json_alimentation as $j_disponibilite){
			
			//Conversion des caractères spéciaux avant insertion dans la BDD
				
				$t_weeks = $parsed_json_alimentation[$cpt]->{'weeks'};
				
				//echo "</br></bt>\n/n";
				//echo count($t_weeks);
				//echo $t_weeks[0]->{'numberWeek'}."</br>";
				//echo "</br></bt>staff_is_host".$t_staff_is_host."</br></bt>";
				$sql = "SELECT * FROM cours_intervenant";
				
				echo $sql;
				
				/*$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				
				
				for( $i=0; $i<count($t_intensity) ; $i++)
				{
					$sql = "INSERT INTO intensite_intervenant VALUES('',".$t_ID." ,".$t_intensity[$i]." )";				
				//	echo $sql;
					$insertion = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
					
				}
				
				
				//unset($sql, $insertion, $t_ID, $t_name, $t_firstname, $t_staff_is_host, $t_staff_is_teacher, $t_weeks, $t_ID, $t_intensity, $t_mail);
				//$cpt = $cpt +1;
			
			
		}	
	*/
	//Arrêt de la connexion à la BDD
	mysqli_close($bdd);
	
	
?>