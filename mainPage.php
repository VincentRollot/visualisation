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

  <body ng-controller="mainPageController"  ng-controller="SalleCtrl">
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
              <input  ng-model= "search"placeholder="rechercher par nom ...">
            </div>
            <div ng-show="groupe1 == 'salle'">
              <input ng-model="research.salle_nom" placeholder="rechercher par salle...">
            </div>        
          </div> 
          <div class="row">
          <button type="button" class="btn btn-default no-bordure btn-lg" id="bRefresh"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
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
        <!-- liste salle -->
        <div class="row" id="list">
          <div ng-show="groupe1 == 'salle'">
            <div ng-repeat="rsalle in rsalles | filter:research | filter:firstLetterFilter | limitTo: limit" >
              <div  ng-class="{research.salle_nom}">
                <a class="afficher" ng-click="submitSalle(rsalle.salle_nom)">{{rsalle.salle_nom}}</a>
              </div> 
             </div>  
          </div>
      
          <!-- liste intervenant -->
          <div ng-show="groupe1 == 'intervenant'">
            <div ng-repeat="rintervenant in rintervenants | filter:search | filter:firstLetterFilter | limitTo: limit" >
              <div  ng-class="{search}">
                <a class="afficher" ng-click="submitIntervenant(rintervenant.int_ID_intervenant)" id="{{rintervenant.int_nom}}{{rintervenant.int_prenom}}">
                {{rintervenant.int_nom}}  
                {{rintervenant.int_prenom}}</a>
              </div> 
            </div>  
          </div>
        </div>
        <div class="row" id="indic">
          <label>indic</label>
        </div>
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