<?php
	require 'connexion.php';

	$intervenant_selected = $_GET['intervenant'];
	//$date_semaine = "2015-03-10";
	//echo "</br>".intval(date("W", strtotime($date_semaine)))."</br>";
	//echo "</br>".$intervenant_selected."</br>";
	//$intervenant_selected = $_GET["id_intervenant"];
	//$date_semaine = $_GET["date_debut_semaine"];


	/*for($i=0;$i<=53;$i++)
	{
		$tableau_semaine[$i]=0;
	}
	*/
	$tableau_semaine=[];
	$total_disponibilite = array();
	// On regarde tout les cours que fait cet intervenant
	$sql = "SELECT * FROM disponibilite WHERE disponibilite_ID_intervenant=".$intervenant_selected." ORDER BY disponibilite_date, disponibilite_heuredebut";
	$info_cours_intervenant = mysqli_query($bdd, $sql) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
	while ($infos_cours_intervenant = mysqli_fetch_array($info_cours_intervenant)) {
		$disponibilite=array();
		//echo "</br> Le professeur est disponible le ".$infos_cours_intervenant['disponibilite_date']." a ".$infos_cours_intervenant['disponibilite_heuredebut'];
		$sql2 = "SELECT * FROM disponibilite_salle WHERE disponibilite_ID=".$infos_cours_intervenant['disponibilite_ID'];
		$dispo_salle = mysqli_query($bdd, $sql2) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
		$compte_disponibilite=mysqli_num_rows($info_cours_intervenant);
		$cpt=0;
		array_push($disponibilite, "'date'"."=>".$infos_cours_intervenant['disponibilite_date'].", 'heuredebut'=>".$infos_cours_intervenant['disponibilite_heuredebut'].", 'duree'=>".$infos_cours_intervenant['disponibilite_duree'].", 'salle' =>[");

		$salle_actuelle=1;
		//On remplit un tableau avec le nombre de cours qu il fait par semaines
		while ($dispos_salles = mysqli_fetch_array($dispo_salle)) {
			$compte_salle=mysqli_num_rows($dispo_salle);
			//echo "il y a ".$compte_salle." salles";
			
			//echo "</br>Le professeur est disponible dans les salles ".($dispos_salles['id_salle']);
			$sql3 = "SELECT * FROM salle WHERE salle_ID=".$dispos_salles['id_salle'];
			$info_salle = mysqli_query($bdd, $sql3) or die('Erreur SQL!<br/>'.mysqli_error($bdd));
			
			
			//On remplit un tableau avec le nombre de cours qu il fait par semaines
			while ($infos_salles = mysqli_fetch_array($info_salle)) {
				//echo "</br>Le professeur est disponible dans les salles ".$infos_salles['salle_nom'];
				//echo "</br> la dispo est : ".$infos_cours_intervenant['disponibilite_date']." et l heure est : ".$infos_cours_intervenant['disponibilite_heuredebut'];
				//array_push($tableau_semaine, $infos_cours_intervenant['disponibilite_date'], $infos_cours_intervenant['disponibilite_heuredebut'], $infos_salles['salle_nom']);
				
				if ($compte_salle == $salle_actuelle) {
					// last row
					array_push($disponibilite, $infos_salles['salle_nom']."]");
				} else {
					// not last row
					array_push($disponibilite, $infos_salles['salle_nom'].",");
				}
				$salle_actuelle=$salle_actuelle+1;
				
			}
			
		}
		//echo "</br>";
		//print_r ($disponibilite);
		if ($compte_salle == $salle_actuelle) {
			// last row
			//array_push($total_disponibilite, "]".$disponibilite);
		} else {
			// not last row
			array_push($total_disponibilite, $disponibilite);
		}
	}
	
	/*for($i=0;$i<count($tableau_semaine);$i++)
	{
		echo "</br>".$tableau_semaine[$i];
	}*/
	
	//	print_r ($total_disponibilite);
	 echo json_encode($total_disponibilite, JSON_PRETTY_PRINT) 
	
	
	/*$book=array(
	array("title" => "JavaScript: The Definitive Guide",
    "author" =>[
            "14", "12"
        ],
	"test"=>[
		"title" => "JavaScript: The Definitive Guide"
	],
    "edition" => 6,
	'info'       =>    array(
                        'name'    =>    'Binny',
                        'site'    =>    'http://www.openjs.com/'
                 )
	),
	array("title" => "JavaScript: The Definitive Guide",
    "author" =>[
            "14", "12"
        ],
	"test"=>[
		"title" => "JavaScript: The Definitive Guide"
	],
    "edition" => 7,
	'info'       =>    array(
                        'name'    =>    'Binny',
                        'site'    =>    'http://www.openjs.com/'
                 )
	)
);
echo 'aaaa';
/*$book = array(
    "title" => "JavaScript: The Definitive Guide",
    "author" => "David Flanagan",
    "edition" => 6
);*/

?>

<script type="text/javascript">
//var book = <?php echo json_encode($total_disponibilite, JSON_PRETTY_PRINT) ?>;
/* var book = {
    "title": "JavaScript: The Definitive Guide",
    "author": "David Flanagan",
    "edition": 6
}; */
//alert('d\u0022 ');
//alert(book[0].date);
</script>

	<?php
	//Fermeture de la connexion à la BDD
	mysqli_close($bdd);
?>