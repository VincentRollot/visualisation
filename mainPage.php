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
        <div class="row" id="searcharea">
          <div  class="col-md-3">                       
            <label><input id="intervenant" type="radio" name="groupe1" ng-model="groupe1"   value="intervenant" /> Intervenant </label>
            <br>
            <label><input id="salle" type="radio" name="groupe1" ng-model="groupe1"  value="salle" /> Salle </label>
          </div>     
          <div class="col-md-6">
            <label> Recherche </label>
            <br>
            <div ng-show="groupe1 == 'intervenant'">
              <input ng-model="search.teachersname" placeholder="rechercher par nom ...">
            </div>
            <div ng-show="groupe1 == 'salle'">
              <input ng-model="search.sitename" placeholder="rechercher par salle...">
            </div>        
          </div> 
          <div class="row">
          <button type="button" class="btn btn-default no-bordure btn-lg" id="bRefresh"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>                  

          <button type="button" class="btn btn-default" id="bMode">Salle</button>
        </div>
        </div>      
        <div class="row" id="salles"> 
          <ul id="onglets"></ul>      
        </div>
        <div class="row" id="planning">
          <div id='calendar'></div>
        </div>
      </div>
      <div  class="col-md-3">
        <div class="row" id="details">
          Veuillez séléctionner un lieu pour voir le détail (nom, adresse, ...)
        </div>
        <div class="row" id="list">
        <label>liste</label>


        <div ng-show="groupe1 == 'intervenant'">
        <div class ="list" ng-repeat="intervenant in intervenants | orderBy:predicate:reverse | filter:search | filter:firstLetterFilter | limitTo: 5" > 
          <div class="row">
            <div class="col-md-4">
              <div class="name" ng-class="red:search.teachersname">{{intervenant.name}}
              </div>
            </div>
            <div>
              <div class="col-md-4">
                <div class="secondname" >{{intervenant.secondname}}
                </div>
              </div>
              <div class="col-md-4">
                <button> Valider intervenant
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
        <div ng-show="groupe1 == 'salle'">
          <div class ="list" ng-repeat="salle in salles | orderBy:predicate:reverse | filter:search | filter:firstLetterFilter | limitTo: 5" >
            <div class="name" >{{salle.firstname}}
            </div>
            <div class="adresss" ng-class="red:searchsitename" >{{salle.second}}
            </div>
            <button> Valider salle
            </button>
          </div>
        </div>
      </div>
        <div class="row" id="indic">
          <label>indic</label>
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