<?php
  require 'connexion.php';

  $intervenant = $_GET["intervenant"];

  $sql = "SELECT * FROM intervenant WHERE int_ID_intervenant = '".$intervenant."'";
  $intervenant_infos = mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));

  $ligne = mysqli_fetch_array($intervenant_infos);

  echo $ligne[3].' '.$ligne[2].'<br/>'.$ligne[1];

  
  //Fermeture de la connexion à la BDD
  mysqli_close($bdd);
      
?>
