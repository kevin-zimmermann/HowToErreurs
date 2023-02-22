<?php
require 'session';
include 'db_connect.php';



//INSCRIPTION
     if(!empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])) {
         $login = $_POST['login'];
         $email = $_POST['email'];
         $password = $_POST['Password'];

         $password = password_hash($password,PASSWORD_BCRYPT);

         $sql = "INSERT INTO utilisateur (login, password, mail) VALUES (:login ,:password, :email)";
         $query = $bdd->prepare($sql);
         $stmt = $query->execute(['login' => $login , 'password' => $password]);

         $messages = "Informations bien enregistrées";

//         $sql2 = "SELECT * FROM utilisateurs WHERE login = :login";
//         var_dump(getInfoUser('utilisateurs','login'));
         $query = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = :login ");
         $query->execute(['login' => $login]);
         $user = $query->fetch(PDO::FETCH_ASSOC);
         $_SESSION = $User;
     }


//PROFIL
     if(!empty($_POST['loginUpdate']) && !empty($_POST['emailUpdate']) && !empty($_POST['passwordUpdate']) ||   !empty($_POST['passwordOld'])){

         $loginUpdate = $_POST['loginUpdate'];
         $emailUpdate = $_POST['emailUpdate'];
         $passwordUpdate = $_POST['passwordupdate'];
         $passwordOld = $_POST['passwordOld'];

         $query = $bdd->prepare("SELECT password FROM utilisateurs WHERE id = :id");
         $query->execute(['id' => $_SESSION['id']]);
         $passwordOldBDD = $query->fetch(PDO::FETCH_ASSOC);

         if(!password_verify($passwordOld,$passwordOldBDD)){

             $passwordUpdate = password_hash($passwordUpdate,PASSWORD_BCRYPT);
             $query = $bdd->prepare("UPDATE utilisateurs SET login = :login , password = :password, email = :email WHERE id = :id");
             $query->execute(['login' => $loginupdate , 'password' => $passwordUpdate, 'email' => $emailUpdate, 'id' => $_SESSION['id']]);

             $query = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = :id");
             $query->execute(['id' => $_SESSION['id']]);
             $user = $query->fetch(PDO::FETCH_ASSOC);
             $_SESSION = $user;


         }else{
             $message = "Mauvais mot de passe";
         }


     }
// }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php if(isset($_SESSION)){
    if(empty($_SESSION)){ ?>
            <h1> Inscription: </h1>
<form method="post">
    <label for="login">Login:</label>
    <input type="text" name="login">

    <label for="email">Email:</label>
    <input type="email" name="email">

    <label for="password">Password:</label>
    <input type="password" name="password">

    <input type="submit" name="submit" value="envoyer">
</form>
        <a href="connexion.php">Connexion </a>
<?php
  }
else{ ?>
    <h1> Profil: </h1>

    <form method="post">
    <label for="login">Login:</label>
    <input type="text" name="loginUpdate" value="<?= $_SESSION['login']?>">

    <label for="email">Email:</label>
    <input type="email" name="emailUpdate" value="<?= $_SESSION['email']?>">

    <label for="password"> Old Password:</label>
    <input type="password" name="passwordOld">


    <label for="password"> New Password:</label>
    <input type="password" name="passwordUpdate">

    <input type="submit" name="submit" value="envoyer">
</form>
    <a href="logout.php">Se déconnecter</a>
    <a href="delete.php">Supprimer votre compte</a>


<?php }
if (!empty($message)){
    echo $message;
}
}?>
</body>
</html>


