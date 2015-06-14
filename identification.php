<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    </head>

<body>

<?php

$login = $_POST["login"];
$password = $_POST["password"];


// strcspn allows us to know the length of the first string which doesn't contain a letter of the second string
if((strcspn($login, '*/,') != strlen($login)) || (strcspn($password, '*/,') != strlen($password))){
    header('Location: index.php');
    exit();
}


require 'connexion.php';

$sql_login = "SELECT user_login FROM users";
$login_req = mysqli_query($bdd, $sql_login) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
$login_db = mysqli_fetch_assoc($login_req);


$i = 1;
$sql = "SELECT COUNT( user_login ) FROM users";
$nb_row= mysqli_query($bdd, $sql) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
$count = mysqli_num_rows($login_req);

while(($login_db['user_login'] != $login) && ($i < ($count + 1))){
    $login_db = mysqli_fetch_assoc($login_req);
    $i = $i + 1;
}

if($i == ($count+1)){
    header('Location: index.php');
    exit();
}

else{
    $sql_id = "SELECT user_login, user_pwd FROM users WHERE user_ID = '".$i."'";
    $id_req = mysqli_query($bdd, $sql_id) or die('Erreur requête SQL!<br/>'.mysqli_error($bdd));
    $id_db = mysqli_fetch_assoc($id_req);

    if($id_db['user_pwd'] == $password){
        session_start();
        $_SESSION['login'] = $login;
        header('Location: mainPage.php');
        exit();
    }
    else{
        header('Location: index.php');
        exit();
    }
}




// In the user didn't try to hack the interface
//else{
    // We connect with an account to try to connect with the login and password

 //   $ldap_bind = ldap_bind($ldap_conn, DN_VIEW, VIEW_PASSWORD);
 //   $directory = ldap_search($ldap_conn,DN_GENERAL, "uid=".$log);
 //   $info1 = ldap_get_entries($ldap_conn, $directory);
 //   $count = 0;
        
 //   $ldap_bind = ldap_bind($ldap_conn, $info1[0]["dn"], $password);
    
 //   authentication_works($ldap_bind, $log, $password);
//}

?>

</body>
</html>