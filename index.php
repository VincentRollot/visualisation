<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gym Suédoise</title>
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
          <form role="form" method="POST" action="mainPage.php">
            <div class="form-group">
              <label for="identify">Identifiant</label>
              <input type="email" class="form-control" id="identify" placeholder="Identifiant">
            </div>
            <div class="form-group">
              <label for="password">Mot de passe</label>
              <input type="password" class="form-control" id="password" placeholder="*******">
            </div>
            <button type="submit" class="btn btn-default" href="//mainPage.php">Connexion</button>
          </form>
        </div>
      </div>
    </div>

    <footer class="col-md-12">
    </footer>

  </body>

</html>
