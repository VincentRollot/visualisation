<?php
session_start();

// If the user tries to go directly to this page, the variable will be empty and he will be redirected to the login page
if(empty($_SESSION['login']))
{
    header('Location: index.php');
    exit();
}
?>


<html xmlns="http://www.w3.org/1999/xhtml" ng-app="GymSuedoise">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gym Suédoise</title>
  <link rel="icon" type="image/gif" href="http://design.gymsuedoise.com/USER20150427/favicon.gif" /> <!-- favicon -->
  <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>-->
  <script src='libs/jquery.min.js'></script>
  <link rel="stylesheet" type="text/css" href="libs/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="libs/jquery-ui.min.css" /> 
  <link rel="stylesheet" type="text/css" href="libs/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="css/customDetailCours.css" /> 
  <link rel="stylesheet" type="text/css" href="css/customMainPage.css" /> 
  <script src="libs/angular.min.js"></script>    
  <script src="libs/jquery-ui.min.js"></script>
  <script src="libs/bootstrap.min.js"></script>
  <script src="js/jsDetails.js"></script>
</head>

  <body ng-controller = "detailsController">

    <?php

    require 'connexion.php';

    $cours = $_GET['cours'];

    $sql_salle_nb = "SELECT cours_salle_ID FROM cours WHERE cours_ID = '".$cours."'";
    $salle_nb_req = mysqli_query($bdd, $sql_salle_nb) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
    $salle_nb_db = mysqli_fetch_assoc($salle_nb_req);

    $sql_salle = "SELECT salle_nom, salle_adresse, salle_cp, salle_ville, salle_capacite FROM salle WHERE salle_ID = '".$salle_nb_db['cours_salle_ID']."'";
    $salle_req = mysqli_query($bdd, $sql_salle) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
    $salle_db = mysqli_fetch_assoc($salle_req);
    
    $salle = $salle_db['salle_nom'];
    $adresse = $salle_db['salle_adresse'];
    $cp = $salle_db['salle_cp'];
    $ville = $salle_db['salle_ville'];
    $capacite = $salle_db['salle_capacite'];

    $sql_zone_nb = "SELECT region_ID FROM region_salle WHERE salle_ID = '".$salle_nb_db['cours_salle_ID']."'";
    $zone_nb_req = mysqli_query($bdd, $sql_zone_nb) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
    $zone_nb_db = mysqli_fetch_assoc($zone_nb_req);

    $sql_zone = "SELECT region_nom FROM region WHERE region_ID = '".$zone_nb_db['region_ID']."'";
    $zone_req = mysqli_query($bdd, $sql_zone) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
    $zone_db = mysqli_fetch_assoc($zone_req);

    $zone = $zone_db['region_nom'];

    $sql_debut = "SELECT cours_heuredebut, cours_duree, cours_type, cours_nb_prof, cours_nb_hote FROM cours WHERE cours_ID = '".$cours."'";
    $debut_req = mysqli_query($bdd, $sql_debut) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
    $debut_db = mysqli_fetch_assoc($debut_req);

    $debut = $debut_db['cours_heuredebut'];
    $duree = $debut_db['cours_duree'];

    $intensite_nb = $debut_db['cours_type'];
    $sql_intensite = "SELECT description FROM intensite WHERE class_level = '".$intensite_nb."'";
    $intensite_req = mysqli_query($bdd, $sql_intensite) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
    $intensite_db = mysqli_fetch_assoc($intensite_req);

    $intensite = $intensite_db['description'];

    $sql_hote = "SELECT id_intervenant FROM cours_intervenant WHERE id_cours = '".$cours."' AND is_teacher = '0'";
    $hote_req = mysqli_query($bdd, $sql_hote) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
    $count_hote = mysqli_num_rows($hote_req);
	
	$i = 0;
    while($i < $count_hote){
      $hote_db = mysqli_fetch_assoc($hote_req);
      $hote_nb[$i] = $hote_db['id_intervenant'];
      $sql_hote_id = "SELECT int_nom, int_prenom FROM intervenant WHERE int_ID_intervenant = '".$hote_nb[$i]."'";
      $hote_id_req = mysqli_query($bdd, $sql_hote_id) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
      $hote_id_db = mysqli_fetch_assoc($hote_id_req);
      $hote[$i] = $hote_id_db['int_nom']." ".$hote_id_db['int_prenom'];
      $i = $i + 1;
    }
	

    $sql_animateur = "SELECT id_intervenant FROM cours_intervenant WHERE id_cours = '".$cours."' AND is_teacher = '1'";
    $animateur_req = mysqli_query($bdd, $sql_animateur) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
    $count = mysqli_num_rows($animateur_req);

    $i = 0;
    while($i < $count){
      $animateur_db = mysqli_fetch_assoc($animateur_req);
      $animateur_nb[$i] = $animateur_db['id_intervenant'];
      $sql_animateur_id = "SELECT int_nom, int_prenom FROM intervenant WHERE int_ID_intervenant = '".$animateur_nb[$i]."'";
      $animateur_id_req = mysqli_query($bdd, $sql_animateur_id) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
      $animateur_id_db = mysqli_fetch_assoc($animateur_id_req);
      $animateur[$i] = $animateur_id_db['int_nom']." ".$animateur_id_db['int_prenom'];
      $i = $i + 1;
    }
	
    
    $nb_animateur = $debut_db['cours_nb_prof'];
    $nb_animateur_possible = $debut_db['cours_nb_prof'] - $count;
    $nb_hote = $debut_db['cours_nb_hote'];
    $nb_hote_possible = $debut_db['cours_nb_hote'] - $count_hote;




    $i = 0;
    $flag = 'oui';
    while($i < $count){
      $sql_intensite_nb = "SELECT class_level FROM intensite_intervenant WHERE id_intervenant = '".$animateur_nb[$i]."'";
      $intensite_nb_req = mysqli_query($bdd, $sql_intensite_nb) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
      $count_intensite = mysqli_num_rows($intensite_nb_req);

      $j=0;
      while($j < $intensite_nb){
        $intensite_nb_db = mysqli_fetch_assoc($intensite_nb_req);
        if($intensite_nb == $intensite_nb_db['class_level']){
          $flag = 'oui';
          $j = $intensite_nb;
        }
        else{
          $sql_animateur_id = "SELECT int_nom, int_prenom FROM intervenant WHERE int_ID_intervenant = '".$animateur_nb[$i]."'";
          $animateur_id_req = mysqli_query($bdd, $sql_animateur_id) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
          $animateur_id_db = mysqli_fetch_assoc($animateur_id_req);
          $animateur[$i] = $animateur_id_db['int_nom']." ".$animateur_id_db['int_prenom'];
          $flag = $animateur[$i]." ne peut pas donner un cours d'intensité ".$intensite;
        }
        $j = $j + 1;
      }
      $i = $i + 1;
    }

    $formation = $flag;
    /*while($i < $count){
      $intensite_nb_db = mysqli_fetch_assoc($intensite_nb_req);

      $sql_intensite = "SELECT description FROM intensite WHERE class_level = '".$intensite_nb_db['class_level']."'";
      $intensite_req = mysqli_query($bdd, $sql_intensite) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
      $intensite_db = mysqli_fetch_assoc($intensite_req);

      $intensite[$i] = $intensite_db['description'];

      $i = $i+1;
    }*/



    ?>
    <div class = "container">
      <div class="content">
        <a href="javascript:history.back()" class="btn btn-default bordure" role="button">Retour</a>
        <div class="titreDetail">Détails du cours</div>

        <div class="row">
          <div id = "colonne_gauche" class="col-md-6">
            <div class="sous-titreDetail">Informations générales :</div>
            <div>
                <p>Zone : <?php echo $zone; ?></p>
                <p>Adresse : <?php echo $adresse; ?> <?php echo $cp; ?> <?php echo $ville; ?></p>
                <p>Salle : <?php echo $salle; ?></p>
                <p>Heure de début : <?php echo $debut; ?></p>
                <p>Durée : <?php echo $duree; ?></p>
                <p>Intensité : <?php echo $intensite; ?></p>
                <p>Capacité du cours : <?php echo $capacite; ?> personnes</p>
            </div>
          </div>
          <div class="col-md-6" id = "colonne_droite">
            <div class="sous-titreDetail">Informations intervenant :</div>
            Animateur : 
            <?php   
            $i = 0;
            while($i < $count){
              ?>
              <a href="mainPage.php?intervenant=<?php print $animateur_nb[$i]; ?>"><?php echo $animateur[$i]; ?></a>
              <?php
              if($i < ($count - 1)){
                echo ", ";
              }
              $i = $i + 1;
            } ?>
			
			</br>Hote : 
            <?php   
            $i = 0;
            while($i < $count_hote){
              ?>
              <a href="mainPage.php?intervenant=<?php print $hote_nb[$i]; ?>"><?php echo $hote[$i]; ?></a>
              <?php
              if($i < ($count_hote - 1)){
                echo ", ";
              }
              $i = $i + 1;
            } ?>
			
            <div class="sous-titreDetail">Rappel indicateur :</div>
            <div>
                <p>Nombre d'animateur : <?php echo $nb_animateur; ?></p>
                <p>Nombre d'animateur encore nécessaire : <?php echo $nb_animateur_possible; ?></p>
                <p>Nombre d'hote : <?php echo $nb_hote; ?></p>
                <p>Nombre d'hote encore nécessaire : <?php echo $nb_hote_possible; ?></p>
                <p>Formation de l’animateur correspond à l’intensité : <?php echo $formation; ?></p>
            </div> 
          </div> 
        </div>
      </div>
    </div>
    <footer>
      <div class="col-md-12" id="infos">
            <div class="col-md-2 no-padding">MENTIONS LEGALES CGU</div>
            <div class="col-md-2 no-padding">Modification : JJ/MM/AAAA</div>
            <div class="col-md-3 no-padding">Copyright 1993-2015 La Gym Suédoise</div>
            <div class="col-md-2 no-padding">Mise à jour : JJ/MM/AAAA</div>
            <div class="col-md-1 no-padding" id="divLegende" ng-click="showModal();">
              <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Légende
            </div>
            <div class="col-md-1 no-padding">
                <a class ='logout' href='logout.php'>Se déconnecter</a>
            </div>
            <div class="col-md-1 no-padding"><img id="logo" src="images/logo.png"></div>
        </div>
    </footer>  
  </body>
</html>
