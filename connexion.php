<?php
	//Connexion à la BDD
		//$bdd = mysqli_connect('localhost','diane_v1', 'sDhZy8LwEH87nUQK') or die("Erreur de connexion au serveur..."); //Connexion serveur 
		$bdd = mysqli_connect('localhost','root', '') or die("Erreur de connexion au serveur...");	//Connexion en local
		mysqli_select_db ($bdd, 'visualisation_local' ) or die("Erreur de connexion à la base de données...");
		mysqli_query($bdd, "SET NAMES 'utf8'");
		
?>