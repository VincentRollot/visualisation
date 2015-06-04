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
        <div class="panel-heading centrer-texte">Tableau de bord récapitulatif</div>

        <!-- Tableau -->
        <table class="table table-striped table-hover">
          <thead>
              <tr>
                <th class="centrer-texte">#</th>
                <th class="centrer-texte">Erreur</th>
                <th class="centrer-texte">Warning</th>
              </tr>
          </thead>

          <tr class="centrer-texte">
            <td>
              J+1
            </td>
            <td>
              <a href="accueilBis.php">4</a>
            </td>
            <td>
              <a href="accueilBis.php">3</a>
            </td>
          </tr>

          <tr class="centrer-texte">
            <td>
              J+2
            </td>
            <td>
              <a href="accueilBis.php">5</a>
            </td>
            <td>
              <a href="accueilBis.php">8</a>
            </td>
          </tr>

          <tr class="centrer-texte">
            <td>
              J+3
            </td>
            <td>
              <a href="accueilBis.php">5</a>
            </td>
            <td>
              <a href="accueilBis.php">6</a>
            </td>
          </tr>

          <tr class="centrer-texte">
            <td>
              J+4
            </td>
            <td>
              <a href="accueilBis.php">2</a>
            </td>
            <td>
              <a href="accueilBis.php">1</a>
            </td>
          </tr>

          <tr class="centrer-texte">
            <td>
              J+5
            </td>
            <td>
              <a href="accueilBis.php">8</a>
            </td>
            <td>
              <a href="accueilBis.php">3</a>
            </td>
          </tr>

          <tr class="centrer-texte">
            <td>
              J+5
            </td>
            <td>
              <a href="accueilBis.php">9</a>
            </td>
            <td>
              <a href="accueilBis.php">6</a>
            </td>
          </tr>

          <tr class="centrer-texte">
            <td>
              J>6
            </td>
            <td>
              <a href="accueilBis.php">3</a>
            </td>
            <td>
              <a href="accueilBis.php">2</a>
            </td>
          </tr>

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
