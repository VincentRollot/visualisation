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
  <link rel="stylesheet" type="text/css" href="css/customMainPage.css" />
  <link rel="stylesheet" type="text/css" href="css/customDetail.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
</head>

  <body ng-controller="coursDetailController">
    <div class="content">
      <button>Retour</button>
      <div class="titreDetail">Détails du cours</div>
      <br>
      <br>

      <div class="row">
        <div class="sous-titreDetail col-md-6">Informations générales :</div>
        <div class="sous-titreDetail col-md-6">Informations intervenant :</div>
      </div>

      <div class="row">
        <div class="col-md-6">Zone : </div>
        <div class="col-md-6">Animateur :</div>
      </div>

      <div class="row">
        <div class="col-md-6">Ville :</div>
        <div class="col-md-6">Hote 1 :</div>
      </div>

      <div class="row">
        <div class="col-md-6">Salle :</div>
        <div class="col-md-6">Hote 2 :</div>
      </div>
      
      <div class="row">
        <div class="col-md-6">Heure de début :</div>
      </div>

      <div class="row">
        <div class="col-md-6">Heure de fin :</div>        
      </div>

      <div class="row">
        <div class="col-md-6">Durée :</div>        
      </div>

      <div class="row">
        <div class="col-md-6">Intensité : {{cours.cours_type}}</div>
        <div class="sous-titreDetail col-md-6">Rappel indicateur :</div>
      </div>

      <div class="row">
        <div class="col-md-6">Abonnement :</div>
        <div class="col-md-6">Nombre d'animateur :</div>  
      </div>

      <div class="row">
        <div class="col-md-6">Animateur :</div>
        <div class="col-md-6">Nombre d'animateur encore possible :</div>    
      </div>

      <div class="row">
        <div class="col-md-6">Hote 1 :</div>
        <div class="col-md-6">Nombre d'hote :</div>   
      </div>

      <div class="row">
        <div class="col-md-6">Hote 2 :</div>
        <div class="col-md-6">Nombre d'hote encore possible :</div>
      </div>

      <div class="row">
        <div class="col-md-6">Capacité du cours :</div>
        <div class="col-md-6">Formation de l’animateur correspond à l’intensité :</div>
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
