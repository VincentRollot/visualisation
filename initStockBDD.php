<?php
	
	require 'connexion.php';


	mysqli_query($bdd, "DELETE FROM region") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
	mysqli_query($bdd, "DELETE FROM region_salle") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
	mysqli_query($bdd, "DELETE FROM salle") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		
	//On remet la BDD à 0
	$sql_zero = "ALTER TABLE region AUTO_INCREMENT=0";
	mysqli_query($bdd, $sql_zero) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
	$sql_zero = "ALTER TABLE region_salle AUTO_INCREMENT=0";
	mysqli_query($bdd, $sql_zero) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
	$sql_zero = "ALTER TABLE salle AUTO_INCREMENT=0";
	mysqli_query($bdd, $sql_zero) or die('Erreur SQL!<br/>'.mysqli_error($bdd));

	mysqli_query($bdd, "DELETE FROM disponibilite") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
	mysqli_query($bdd, "DELETE FROM disponibilite_salle") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
	mysqli_query($bdd, "DELETE FROM intervenant") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
	mysqli_query($bdd, "DELETE FROM intensite_intervenant") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
	mysqli_query($bdd, "DELETE FROM intervenant_disponibilite_semaine") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		
	//On remet la BDD à 0
	$sql_zero = "ALTER TABLE disponibilite AUTO_INCREMENT=0";
	mysqli_query($bdd, $sql_zero) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
	$sql_un = "ALTER TABLE disponibilite_salle AUTO_INCREMENT=0";
	mysqli_query($bdd, $sql_un) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
	$sql_un = "ALTER TABLE intensite_intervenant AUTO_INCREMENT=0";
	mysqli_query($bdd, $sql_un) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
	$sql_un = "ALTER TABLE intervenant_disponibilite_semaine AUTO_INCREMENT=0";
	mysqli_query($bdd, $sql_un) or die('Erreur SQL!<br/>'.mysqli_error($bdd));

	mysqli_query($bdd, "DELETE FROM cours") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
	mysqli_query($bdd, "DELETE FROM cours_intervenant") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
		
	//On remet la BDD à 0
		
	$sql_un = "ALTER TABLE cours_intervenant AUTO_INCREMENT=0";
	mysqli_query($bdd, $sql_un) or die('Erreur SQL!<br/>'.mysqli_error($bdd));

	mysqli_query($bdd, "DELETE FROM erreurs") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
	mysqli_query($bdd, "ALTER TABLE erreurs AUTO_INCREMENT=0") or die ("Erreur SQL ! </br>".mysqli_error($bdd));

	mysqli_query($bdd, "DELETE FROM indicateurs") or die ("Erreur SQL ! </br>".mysqli_error($bdd));
	mysqli_query($bdd, "ALTER TABLE indicateurs AUTO_INCREMENT=0") or die ("Erreur SQL ! </br>".mysqli_error($bdd));

	mysqli_close($bdd);

	require 'stockBDD_salle.php';
	require 'stockBDD_region.php';
	require 'stockAlimentation.php';
	require 'stockResolution.php';
	require 'erreurDistance.php';
	require 'erreursReglesMetier.php';
	require 'indicateur_mauvaise_formation.php';
	require 'indicateur_taux_erreur.php';


	$sql = "INSERT INTO date_maj (date_maj) VALUES (NOW())";
	mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
	
?>