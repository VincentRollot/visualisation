<link rel="stylesheet" type="text/css" href="css/customMainPage.css" />
<link rel="stylesheet" type="text/css" href="css/customAccueil.css" />
<link rel="stylesheet" href="dist/themes/default/style.min.css" />
<script src="dist/jstree.min.js"></script>
<script src="js/jsNav.js"></script>
<div  ng-app="GymSuedoise"class="col-md-2" id="nav">
  <div ng-controller="mainPageController" class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
      <i class="fa fa-search"></i></span>
      <input id="research"
             type="text"
             class="form-control bordure"
             ng-model="search"
             placeholder="Rechercher...">
    </div>
  </div>
  <div id="jstree">    
  </div>
</div>
