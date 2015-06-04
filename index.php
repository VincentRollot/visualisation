<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gym Suédoise</title>
    <link rel="icon" type="image/gif" href="http://design.gymsuedoise.com/USER20150427/favicon.gif" /> <!-- favicon -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="libs/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="libs/jquery-ui.min.css" /> 
    <link rel="stylesheet" type="text/css" href="libs/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="css/custom.css" />
  </head>

  <body>

    <header>
      <img src="images/logo.png">
    </header>
    <div class="container">
      <div class="row">
        <div class="col-md-offset-4 col-md-4" id="form">
          <form role="form" method="POST" action="accueil.php">
            <div class="form-group">
              <label for="identify">Identifiant</label>
              <input type="email" class="form-control" id="identify" placeholder="Identifiant">
            </div>
            <div class="form-group">
              <label for="password">Mot de passe</label>
              <input type="password" class="form-control" id="password" placeholder="*******">
            </div>
            <button type="submit" class="btn btn-default" href="//accueil.php">Connexion</button>
          </form>
        </div>
      </div>
    </div>

  </body>

</html>
