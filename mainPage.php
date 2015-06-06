<html xmlns="http://www.w3.org/1999/xhtml" ng-app="GymSuedoise">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gym Suédoise</title>
  <link rel="icon" type="image/gif" href="http://design.gymsuedoise.com/USER20150427/favicon.gif" /> <!-- favicon -->
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
      <div  class="col-md-7">
        <div class="row" id="search">
          search
        </div>
        <div class="row" id="salles">
          salles
        </div>
        <div class="row" id="planning">
          <div id='calendar'></div>
        </div>
      </div>
      <div  class="col-md-3">
        <div class="row" id="details">
          Veuillez séléctionner un lieu pour voir le détail (nom, adresse, ...)
        </div>
        <div class="row" id="indic">
          indic
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