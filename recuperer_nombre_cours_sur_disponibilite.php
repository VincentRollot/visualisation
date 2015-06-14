<?php
	require 'connexion.php';

	//intervenant_selected = 28;
	//$date_semaine = "2015-03-03";

	$intervenant_selected = $_GET["id_intervenant"];
	$date_semaine = $_GET["date_debut_semaine"];


	for($i=0;$i<=53;$i++)
	{
		$tableau_semaine[$i]=0;
	}
	
	// On regarde tout les cours que fait cet intervenant
	$sql = "SELECT * FROM cours_intervenant WHERE id_intervenant=".$intervenant_selected;
	$info_cours_intervenant = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
	while ($infos_cours_intervenant = mysqli_fetch_array($info_cours_intervenant)) {
		$sql = "SELECT * FROM cours WHERE cours_ID=".$infos_cours_intervenant['id_cours'];
		$info_cours = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
		//On remplit un tableau avec le nombre de cours qu il fait par semaines
		while ($infos_cours = mysqli_fetch_array($info_cours)) {
			 $tableau_semaine[intval(date("W", strtotime($infos_cours['cours_date'])))]=$tableau_semaine[intval(date("W", strtotime($infos_cours['cours_date'])))]+1;
		}
		
	}
	
	$nmbr_max=0;
	
	// On recherche le nombre de cours maximum qu il souhaitait faire cette semaine
	$sql = "SELECT * FROM intervenant_disponibilite_semaine WHERE dispo_semaine_ID=".intval(date("W", strtotime($date_semaine)));
	$valeur_max = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
	while ($lessonsMax = mysqli_fetch_array($valeur_max)) {
		/*if($lessonsMax['lessonsMax']<$tableau_semaine[intval(date("W", strtotime($date_semaine)))])
		{
			echo "</br>On a trouve un problème ! Le professeur id : ".$intervenant_selected." souhaite faire maximum ".$lessonsMax['lessonsMax']." et il fait ".$tableau_semaine[intval(date("W", strtotime($date_semaine)))]." cours la semaine ".$lessonsMax['numero_semaine'];
		}
		*/
		$nmbr_max=$lessonsMax['lessonsMax'];
	}
		
	//}
	$lst_erreurs = [];
	array_push($lst_erreurs, $tableau_semaine[intval(date("W", strtotime($date_semaine)))]);
	array_push($lst_erreurs, $nmbr_max);
	
	echo json_encode($lst_erreurs)."</br>";
	
	
	//Fermeture de la connexion à la BDD
	mysqli_close($bdd);
?>