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
  <link rel="stylesheet" type="text/css" href="css/customDetailIntervenant.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
</head>

  <body ng-controller="mainPageController">

    <?php 

      require 'connexion.php';

      $intervenant = $_GET['intervenant'];


      $sql_animateur = "SELECT int_nom, int_prenom FROM intervenant WHERE int_ID_intervenant = '".$intervenant."'";
      $animateur_req = mysqli_query($bdd, $sql_animateur) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
      $animateur_db = mysqli_fetch_assoc($animateur_req);
      $nom = $animateur_db['int_nom'];
      $prenom = $animateur_db['int_prenom'];

      $sql_intensite_nb = "SELECT class_level FROM intensite_intervenant WHERE id_intervenant = '".$intervenant."'";
      $intensite_nb_req = mysqli_query($bdd, $sql_intensite_nb) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
      $count = mysqli_num_rows($intensite_nb_req);
      $i=0;

      while($i < $count){
        $intensite_nb_db = mysqli_fetch_assoc($intensite_nb_req);

        $sql_intensite = "SELECT description FROM intensite WHERE class_level = '".$intensite_nb_db['class_level']."'";
        $intensite_req = mysqli_query($bdd, $sql_intensite) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
        $intensite_db = mysqli_fetch_assoc($intensite_req);

        $intensite[$i] = $intensite_db['description'];

        $i = $i+1;
      }
      


    ?>
    <div class="container">
      <a href="javascript:history.back()" class="btn btn-default bordure" role="button">Retour</a>
      <div class="titreDetail">Détails de l'intervenant</div>

      <div class="col-md-6 col-md-offset-4">
        <p>Nom : <?php echo $nom; ?></p>
        <p>Prénom : <?php echo $prenom; ?></p>
        <p>Disponibilité :</p>
        <p>Intensité : 
         <?php   
            $i = 0;
            while($i < $count){
              echo $intensite[$i];
              if($i < ($count - 1)){
                echo ", ";
              }
              $i = $i + 1;
            } ?>
          </p>
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
