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
  <link rel="stylesheet" href="dist/themes/default/style.min.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>

  <link href='libs/fullcalendar.css' rel='stylesheet' />
  <link href='libs/fullcalendar.print.css' rel='stylesheet' media='print' />
  <script src='libs/moment.min.js'></script>
  <script src='libs/jquery.min.js'></script>
  <script src='libs/fullcalendar.min.js'></script>
  <script src='libs/fr.js'></script>
</head>

  <body ng-controller="mainPageController">
    <ng-include src="'nav.php'"></ng-include>    
    <div class="col-md-offset-3 col-md-5">
      <div class="row">
        <div class="btn-group" role="group">
          <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle bordure">Choisir planning à afficher
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a href="#scolaire">Période scolaire</a></li>
            <li><a href="#estival">Période estival</a></li>
          </ul>
        </div>   
        <button type="button" class="btn btn-default no-bordure btn-lg"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>                  
      </div>
    </div>
    <br><br><br><br>
    <div class="col-md-offset-2 col-md-4">
      <div class="panel panel-primary" id="tableau">
      <!-- Contenu du panel -->

        <!-- Titre -->
        <div class="panel-heading centrer-texte">Planning période scolaire</div>

        <!-- Tableau -->
        <table class="table table-hover">
          <thead>
              <tr>
                <th class="centrer-texte">Ville</th>
                <th class="centrer-texte">Nombre d'erreur</th>
              </tr>
          </thead>
          <tbody>

          <tr class="centrer-texte">
            <td>
              <a href="mainPage.php">Chartres</a>
            </td>
            <td>11
            </td>
          </tr>

          <tr class="centrer-texte">
            <td>
              <a href="mainPage.php">Chatenay-Malabry</a>
            </td>
            <td>11
            </td>
          </tr>

          <tr class="centrer-texte">
            <td>
              <a href="mainPage.php">Caen</a>
            </td>
            <td>10
            </td>
          </tr>

          <tr class="centrer-texte">
            <td>
              <a href="mainPage.php">3e arrondissement</a>
            </td>
            <td>4
            </td>
          </tr>

          <tr class="centrer-texte">
            <td>
              <a href="mainPage.php">8e arrondissement</a>
            </td>
            <td>2
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <ng-include src="'legende.php'"></ng-include>
    <ng-include src="'footer.php'"></ng-include>       
  </body>
  
  <script src="libs/angular.min.js"></script>    
  <script src="libs/jquery-ui.min.js"></script>
  <script src="libs/bootstrap.min.js"></script>
  <script src="js/jsMainPage.js"></script>
</html>
