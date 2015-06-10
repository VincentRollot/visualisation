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
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="libs/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="libs/jquery-ui.min.css" /> 
  <link rel="stylesheet" type="text/css" href="libs/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="css/customDetail.css" />
</head>

  <body ng-controller = "mainPageController">

    <?php

    require 'connexion.php';

    $cours = $_GET['cours'];

    $zone = "zone";
    $ville = "ville";
    $salle = "salle";

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
    $capacite = "capacite";


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
    $nb_animateur_possible = "animateur possible";
    $nb_hote = $debut_db['cours_nb_hote'];
    $nb_hote_possible = "hote possible";
    $formation = "oui";

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
                <p>Ville : <?php echo $ville; ?></p>
                <p>Salle : <?php echo $salle; ?></p>
                <p>Heure de début : <?php echo $debut; ?></p>
                <p>Durée : <?php echo $duree; ?></p>
                <p>Intensité : <?php echo $intensite; ?></p>
                <p>Capacité du cours : <?php echo $capacite; ?></p>
            </div>
          </div>
          <div class="col-md-6" id = "colonne_droite">
            <div class="sous-titreDetail">Informations intervenant :</div>
            Animateur : 
            <?php   
            $i = 0;
            while($i < $count){
              ?>
              <a href="detailIntervenant.php?intervenant=<?php print $animateur_nb[$i]; ?>"><?php echo $animateur[$i]; ?></a>
              <?php
              if($i < ($count - 1)){
                echo ", ";
              }
              $i = $i + 1;
            } ?>

            <div class="sous-titreDetail">Rappel indicateur :</div>
            <div>
                <p>Nombre d'animateur : <?php echo $nb_animateur; ?></p>
                <p>Nombre d'animateur encore possible : <?php echo $nb_animateur_possible; ?></p>
                <p>Nombre d'hote : <?php echo $nb_hote; ?></p>
                <p>Nombre d'hote encore possible : <?php echo $nb_hote_possible; ?></p>
                <p>Formation de l’animateur correspond à l’intensité : <?php echo $formation; ?></p>
            </div> 
          </div> 
        </div>
      </div>
    </div>
    <ng-include src="'legende.php'"></ng-include>
    <ng-include src="'footer.php'"></ng-include>   
  </body>

<script src="libs/jquery-2.1.3.min.js"></script>
<script src="libs/angular.min.js"></script>    
<script src="libs/jquery-ui.min.js"></script>
<script src="libs/bootstrap.min.js"></script>
<script src="js/jsMainPage.js"></script>
</html>
