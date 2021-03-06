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
  <link rel="stylesheet" type="text/css" href="css/customDetailIntervenant.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
</head>

  <body ng-controller="mainPageController">

    <?php 

      require 'connexion.php';

      $intervenant = $_GET['intervenant'];


      $sql_animateur = "SELECT int_nom, int_prenom FROM intervenant WHERE int_ID_intervenant = '".$intervenant."'";
      $animateur_req = mysqli_query($bdd, $sql_animateur) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
      $animateur_db = mysqli_fetch_assoc($animateur_req);
      $nom = $animateur_db['int_nom'];
      $prenom = $animateur_db['int_prenom'];

      $sql_intensite_nb = "SELECT class_level FROM intensite_intervenant WHERE id_intervenant = '".$intervenant."'";
      $intensite_nb_req = mysqli_query($bdd, $sql_intensite_nb) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
      $count = mysqli_num_rows($intensite_nb_req);
      $i=0;

      while($i < $count){
        $intensite_nb_db = mysqli_fetch_assoc($intensite_nb_req);

        $sql_intensite = "SELECT description FROM intensite WHERE class_level = '".$intensite_nb_db['class_level']."'";
        $intensite_req = mysqli_query($bdd, $sql_intensite) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
        $intensite_db = mysqli_fetch_assoc($intensite_req);

        $intensite[$i] = $intensite_db['description'];

        $i = $i+1;
      }
      


    ?>
    <div class="container">
      <a href="javascript:history.back()" class="btn btn-default bordure" role="button">Retour</a>
      <div class="titreDetail">Détails de l'intervenant</div>

      <div class="col-md-6 col-md-offset-5">
        <p>Nom : <?php echo $nom; ?></p>
        <p>Prénom : <?php echo $prenom; ?></p>
        <p>Disponibilité :</p>
        <p>Intensité : 
         <?php   
            $i = 0;
            while($i < $count){
              echo $intensite[$i];
              if($i < ($count - 1)){
                echo ", ";
              }
              $i = $i + 1;
            } ?>
          </p>
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
  

  <script src="libs/jquery-2.1.3.min.js"></script>
  <script src="libs/angular.min.js"></script>    
  <script src="libs/jquery-ui.min.js"></script>
  <script src="libs/bootstrap.min.js"></script>
  <script src="js/jsMainPage.js"></script>
</html>
