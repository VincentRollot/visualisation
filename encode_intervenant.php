<?php
	//Connexion à la BDD
		require 'connexion.php';
		
	//Sélectionner la table INTERVENANT dans la BDD
		$sql_info = "SELECT * FROM intervenant";
		$donnees = mysqli_query($bdd, $sql_info) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
		//printf ("Select a retourné un fichier avec %d lignes.<br/>", mysqli_num_rows($donnees));
		
		$tab_intervenant = array();
		
	//On range les données d'un intervenant dans un tableau
		while($ligne = mysqli_fetch_object($donnees)){
			$tab_intervenant[] = $ligne;
			
		}		

		$encode_intervenant = json_encode($tab_intervenant);
		echo $encode_intervenant;
		
		
		//var_dump(json_encode($tab_intervenant));
		
	

	//Fermeture de la connexion à la BDD
		mysqli_close($bdd);
	
	




?>