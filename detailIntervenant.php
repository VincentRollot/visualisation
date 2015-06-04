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

  <body ng-controller="mainPageController">
    <div class="content">
      <button>Retour</button>
      <div class="titreDetail">Détails de l'intervenant</div>
      <br>
      <br>

      <div>Nom :</div>
      <div>Prénom :</div>
      <div>Age :</div>
      <div>Localisation :</div>
      <div>Disponibilité :</div>
      <div>Intensité :</div>
      <div>Ancienneté :</div>
      <div>Souhaits particuliers :</div>
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
