<?php
	//Connexion à la BDD
		require 'connexion.php';
		
	//Sélectionner la table SALLE dans la BDD
		$sql_info = "SELECT * FROM salle";
		$donnees = mysqli_query($bdd, $sql_info) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
		//echo mysqli_num_rows($donnees);
		
		$salle_info = array();
		
	//On range les données d'une salle dans un tableau
		while($d=mysqli_fetch_object($donnees)) {
			$salle_info[] = $d;
		}
		
		echo json_encode($salle_info);
	

	//Fermeture de la connexion à la BDD
		mysqli_close($bdd);
	
	




?>