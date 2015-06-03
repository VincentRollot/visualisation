<html xmlns="http://www.w3.org/1999/xhtml" ng-app="GymSuedoise">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gym Suédoise</title>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="libs/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="libs/jquery-ui.min.css" /> 
  <link rel="stylesheet" type="text/css" href="libs/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="css/customMainPage.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
  <link href='libs/fullcalendar.css' rel='stylesheet' />
  <link href='libs/fullcalendar.print.css' rel='stylesheet' media='print' />
  <script src='libs/moment.min.js'></script>
  <script src='libs/jquery.min.js'></script>
  <script src='libs/fullcalendar.min.js'></script>
  <script src='libs/fr.js'></script>
  
</head>

  <body ng-controller="mainPageController">
  <?php
    $url = "planningResolu.json";
    $json_file = file_get_contents($url);
    $json_file;
  ?>
      <div  class="col-md-2" id="nav">
        nav
      </div>
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
        <div class="row" id="switch">
          switch
        </div>
      </div>
      <div  class="col-md-3">
        <div class="row" id="details">
          détails
        </div>
        <div class="row" id="indic">
          indic
        </div>
      </div>
    
      <div class="col-md-12 "id="infos">
        <div class="col-md-3">MENTIONS LEGALES CGU</div>
        <div class="col-md-6">Copyright 1993-2015 La Gym Suédoise</div>
        <div class="col-md-2" id="divLegende" ng-click="showModal();">Légende</div>
        <div class="col-md-1"><img id="logo" src="images/logo.png"></div>
      </div>

      <div class="modal fade" id="legende" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              Tu mets ton titre ici
            </div>
            <div class="modal-body">
              Là c'est ton corps
            </div>
            <div class="modal-footer">
              Tu mets un pied de page ici
            </div>
          </div>
        </div>
      </div>
  </body>


<script src="libs/angular.min.js"></script>    
<script src="libs/jquery-ui.min.js"></script>
<script src="libs/bootstrap.min.js"></script>
<script src="js/jsMainPage.js"></script>
</html>