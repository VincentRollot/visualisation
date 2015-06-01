<?php
	//Connexion à la BDD
		//$bdd = mysqli_connect('localhost','diane_v1', 'sDhZy8LwEH87nUQK') or die("Erreur de connexion au serveur..."); //Connexion serveur 
		$bdd = mysqli_connect('localhost','root', '') or die("Erreur de connexion au serveur...");	//Connexion en local
		mysqli_select_db ($bdd, 'visualisation1' ) or die("Erreur de connexion à la base de données...");
		mysqli_query($bdd, "SET NAMES 'utf-8'");
		
		$salle_ID_post = 3;

	
		
	//On affiche les coordonnées d'une salle		
		echo urldecode($salle_info->{'salle_nom'}.'<br/>'.$salle_info->{'salle_adresse'}.' '.$salle_info->{'salle_cp'});
	

?>