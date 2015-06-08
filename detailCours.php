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
            Animateur : <?php echo $animateur; ?>

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
