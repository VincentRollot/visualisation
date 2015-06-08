<html xmlns="http://www.w3.org/1999/xhtml" ng-app="GymSuedoise">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gym Suédoise</title>
  <link rel="icon" type="image/gif" href="http://design.gymsuedoise.com/USER20150427/favicon.gif" /> <!-- favicon -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="libs/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="libs/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="css/customDetail.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
</head>

  <body>

    <?php

    $cours = $_GET['cours'];
    $zone = "zone";
    $ville = "ville";
    $salle = "salle";
    $debut = "début";
    $duree = "durée";
    $intensite = "intensite";
    $capacite = "capacite";
    $animateur = "animateur";
    $nb_animateur = "animateur";
    $nb_animateur_possible = "animateur possible";
    $nb_hote = "animateur";
    $nb_hote_possible = "hote possible";
    $formation = "oui";

    ?>

    <div class="content">
      <a href="javascript:history.back()" class="btn btn-default bordure" role="button">Retour</a>
      <div class="titreDetail">Détails du cours</div>
      <br>
      <br>

      <div class="row">
        <div class="sous-titreDetail col-md-6">Informations générales :</div>
        <div class="sous-titreDetail col-md-6">Informations intervenant :</div>
      </div>

      <div class="row">
        <div class="col-md-6">Zone : <?php echo $zone; ?></div>
        <div class="col-md-6">Animateur : <?php echo $animateur; ?></div>
      </div>

      <div class="row">
        <div class="col-md-6">Ville : <?php echo $ville; ?></div>
      </div>

      <div class="row">
        <div class="col-md-6">Salle : <?php echo $salle; ?></div>
      </div>
      
      <div class="row">
        <div class="col-md-6">Heure de début : <?php echo $debut; ?></div>        
        <div class="sous-titreDetail col-md-6">Rappel indicateur :</div>
      </div>

      <div class="row">
        <div class="col-md-6">Durée : <?php echo $duree; ?></div>  
        <div class="col-md-6">Nombre d'animateur : <?php echo $nb_animateur; ?></div>       
      </div>

      <div class="row">
        <div class="col-md-6">Intensité : <?php echo $intensite; ?></div>
        <div class="col-md-6">Nombre d'animateur encore possible : <?php echo $nb_animateur_possible; ?></div> 
      </div>

      <div class="row">        
        <div class="col-md-6">Capacité du cours : <?php echo $capacite; ?></div>
        <div class="col-md-6">Nombre d'hote : <?php echo $nb_hote; ?></div>   
      </div>

      <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">Nombre d'hote encore possible : <?php echo $nb_hote_possible; ?></div>
      </div>

      <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">Formation de l’animateur correspond à l’intensité : <?php echo $formation; ?></div>
      </div> 
    </div> 
    <ng-include src="'legende.php'"></ng-include>
    <ng-include src="'footer.php'"></ng-include>    
  </body>
 
<script src="libs/bootstrap.min.js"></script>
</html>
