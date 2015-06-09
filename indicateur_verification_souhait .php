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
			/*foreach ($line as $col_value) {
				echo $col_value . '<br />';
			}*/
			//$id_cours = $line['id_cours'];
			$id_intervenant = $line['int_ID_intervenant'];
			//echo "</br>".$line[$cpt]."</br>";
			//echo "</br>".$id_intervenant."</br>";
			
			
			$sql1 = "SELECT * FROM cours_intervenant WHERE id_intervenant=".$id_intervenant;
			$cours = mysqli_query($bdd, $sql1) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
			$numero_semaine=1;
			$nombre_de_cours_semaine=0;
			$fin_semaine=FALSE;
			//$intensite = mysqli_fetch_array($cours);
			while ($cours_prof = mysqli_fetch_array($cours)) {
				$nombre_de_cours_semaine=0;
				
				//echo " ".$cours_prof['id_cours'];
				//echo $cours_prof['id_cours'];
				
				$sql2 = "SELECT * FROM cours WHERE cours_ID=".$cours_prof['id_cours'];
				$info_cours = mysqli_query($bdd, $sql2) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
				while ($infos_cours = mysqli_fetch_array($info_cours)) {
					//echo " ".$infos_cours['cours_date'];
					//echo "fffffffffffffff".$infos_cours['cours_ID']." a h: ".$infos_cours['cours_heuredebut'];
					$sql3 = "SELECT * FROM disponibilite WHERE disponibilite_ID_intervenant=".$id_intervenant." AND disponibilite_date='".$infos_cours['cours_date']."'";
					$disponibilite_ok=FALSE;
					$disponibilite_prof = mysqli_query($bdd, $sql3) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
					$horaire_disponibilite_debut;
					$horaire_cours_debut;
					//echo "</br>bb".$infos_cours['cours_ID']."</br>";
					//echo "  id ".$id_intervenant." dispo le ".$infos_cours['cours_date'];
					while ($disponibilite_jour = mysqli_fetch_array($disponibilite_prof)) {
						//echo "  AAAA";
						//echo $disponibilite_jour['disponibilite_duree'];
						//echo " ".$disponibilite_jour['disponibilite_heuredebut'];
						//echo " temps ".date("'t'? HH  MM", strtotime($disponibilite_jour['disponibilite_heuredebut']));
						//echo $disponibilite_jour['disponibilite_heuredebut'];
						$horaire_disponibilite_debut=explode(":", $disponibilite_jour['disponibilite_heuredebut']);
						$horaire_cours_debut=explode(":", $infos_cours['cours_heuredebut']);
						//echo "PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP".$horaire_cours_debut[0];
						
						//$hours = floor($disponibilite_jour['disponibilite_duree']/60);
						$horaire_cours_fin=$horaire_cours_debut;
						//$horaire_cours_fin[1]=$horaire_cours_fin[1]+$disponibilite_jour['disponibilite_duree']/60;
						$heures = floor($disponibilite_jour['disponibilite_duree']/60);
						$horaire_cours_fin[1]=$horaire_cours_fin[1]+$infos_cours['cours_duree'];
						//echo "duree ".$infos_cours['cours_dure'];
						//echo $disponibilite_jour['disponibilite_duree'];
						$heures = floor($horaire_cours_fin[1]/60);
						$horaire_cours_fin[0]=$horaire_cours_fin[0]+$heures;
						$horaire_cours_fin[1]=$horaire_cours_fin[1]-$heures*60;
						//$horaire_cours_fin=date("HH MM",$horaire_cours_fin);
						
						
						//$hours = floor($disponibilite_jour['disponibilite_duree']/60);
						$disponibilite_cours_fin=$horaire_disponibilite_debut;
						//$horaire_cours_fin[1]=$horaire_cours_fin[1]+$disponibilite_jour['disponibilite_duree']/60;
						$heures = floor($disponibilite_jour['disponibilite_duree']/60);
						$disponibilite_cours_fin[1]=$disponibilite_cours_fin[1]+$disponibilite_jour['disponibilite_duree'];
						//echo "duree ".$infos_cours['cours_dure'];
						//echo $disponibilite_jour['disponibilite_duree'];
						$heures = floor($disponibilite_cours_fin[1]/60);
						$disponibilite_cours_fin[0]=$disponibilite_cours_fin[0]+$heures;
						$disponibilite_cours_fin[1]=$disponibilite_cours_fin[1]-$heures*60;
						//$horaire_cours_fin=date("HH MM",$horaire_cours_fin);
						//echo " ok pour ".$horaire_cours_debut[0].":".$horaire_cours_debut[1];
						//echo " jusqu'à ".$horaire_cours_fin[0].":".$horaire_cours_fin[1];
						if($horaire_disponibilite_debut[0]<$horaire_cours_debut[0])
						{
							//echo " ".$horaire[0];
							//echo " ok pour ".$horaire_cours_debut[0]."";
							if($disponibilite_cours_fin[0]>$horaire_cours_fin[0])
							{
								$disponibilite_ok=TRUE;
								//echo " ".$horaire[0];
								//echo " ok pour ".$horaire_cours_debut[0].":".$horaire_cours_debut[1];
								//echo " jusqu'à ".$horaire_cours_fin[0].":".$horaire_cours_fin[1];
							}
							else if($disponibilite_cours_fin[0]==$horaire_cours_fin[0])
							{
								//echo " ".$horaire[0];
								if($disponibilite_cours_fin[1]>=$horaire_cours_fin[1])
								{
									//echo " ok pour ".$horaire_cours_debut[0].":".$horaire_cours_debut[1];
									//echo " jusqu'à ".$horaire_cours_fin[0].":".$horaire_cours_fin[1];
									$disponibilite_ok=TRUE;
								}
								
								else
								{
									//echo " PROBLEME !!! ";
								}								
							}
							else
							{
								//echo " PROBLEME !!! ";
							}
						}
						
						else if($horaire_disponibilite_debut[0]==$horaire_cours_debut[0])
						{
							//echo " ".$horaire[0];
							//echo " ok pour ".$horaire_cours_debut[0]."";
							//echo " ok pour ".$horaire_cours_debut[0].":".$horaire_cours_debut[1];
							//echo " jusqu'à ".$horaire_cours_fin[0].":".$horaire_cours_fin[1];
							if($horaire_disponibilite_debut[1]<=$horaire_cours_debut[1])
							{
								//echo " ok pour ".$horaire_cours_debut[0].":".$horaire_cours_debut[1];
								//echo " jusqu'à ".$horaire_cours_fin[0].":".$horaire_cours_fin[1];
								if($disponibilite_cours_fin[0]>$horaire_cours_fin[0])
								{
									$disponibilite_ok=TRUE;
									//echo " ".$horaire[0];
									//echo " ok pour ".$horaire_cours_debut[0].":".$horaire_cours_debut[1];
									//echo " jusqu'à ".$horaire_cours_fin[0].":".$horaire_cours_fin[1];
								}
								else if($disponibilite_cours_fin[0]==$horaire_cours_fin[0])
								{
									//echo " ".$horaire[0];
									//echo " ok pour ".$horaire_cours_debut[0].":".$horaire_cours_debut[1];
									//echo " jusqu'à ".$horaire_cours_fin[0].":".$horaire_cours_fin[1];
									if($disponibilite_cours_fin[1]>=$horaire_cours_fin[1])
									{
										//echo " ok pour le cours id ".$cours_prof['id_cours']." debutant a ".$horaire_cours_debut[0].":".$horaire_cours_debut[1];
										//echo " jusqu'à ".$horaire_cours_fin[0].":".$horaire_cours_fin[1];
										$disponibilite_ok=TRUE;
									}
									
									else
									{
										//echo " PROBLEME !!! ";
									}								
								}
							}
						}
						
						else
						{
							//echo " PROBLEME !!! ";
						}
						
						
					}
					/*echo " on est sorti ".$horaire_cours_debut[0];
					echo  " nombre de resultats =".mysqli_num_rows($disponibilite_prof);*/
					
					
					if($disponibilite_ok==FALSE)
					{
						if(mysqli_num_rows($disponibilite_prof)==0)
						{
							echo "</br> PROBLEME !!! ";
							echo "".$disponibilite_jour;
							echo "Le professeur ".$id_intervenant." n a demande aucun cours le ".$infos_cours['cours_date'].". Il ne peut assurer le cours ".$cours_prof['id_cours'];
						}
						else
						{
							echo "</br> ERREUR !!! ";
							//echo "le cours id ".$infos_cours['cours_ID']." débute à ".$horaire_cours_debut[0].":".$horaire_cours_debut[1];
							echo "le cours id ".$cours_prof['id_cours']." débute à ".$horaire_cours_debut[0].":".$horaire_cours_debut[1];
							echo " et finit à ".$horaire_cours_fin[0].":".$horaire_cours_fin[1];
							echo " l enseignant id ".$id_intervenant." debute à ".$horaire_disponibilite_debut[0].":".$horaire_disponibilite_debut[1];
							echo " et finit à ".$disponibilite_cours_fin[0].":".$disponibilite_cours_fin[1];
						}
						
					}
				}
				
			}

			
			//echo "</br>On a finit ce professeur</br>";
			//echo $id_cours;
			$cpt = $cpt+1 ;
			
		}

		

	//Arrêt de la connexion à la BDD
	mysqli_close($bdd);
	
	
?>