<?php
	//Connexion à la BDD
		require 'connexion.php';
		
	//Sélectionner la table SALLE dans la BDD
		$sql_info = "SELECT * FROM salle";
		$donnees = mysqli_query($bdd, $sql_info) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
		//printf ("Select a retourné un fichier avec %d lignes.<br/>", mysqli_num_rows($donnees));
		
		$tab_salle = array();
		
	//On range les données d'une salle dans un tableau
		while($ligne = mysqli_fetch_object($donnees)){
			$tab_salle[] = $ligne;
			
		}
		//printf (count($salle_info));
		
		
		//foreach ($salle_info as $s){
			//echo $s;
			//echo '<br/>';
			
		//}
		
		
		$encode_salle = json_encode($tab_salle);
		echo $encode_salle;
		
		
		//var_dump(json_encode($tab_salle));
		
	

	//Fermeture de la connexion à la BDD
		mysqli_close($bdd);
	
	




?>