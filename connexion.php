<?php
require 'session.php';
include 'db_connect.php';
if(!empty($_POST['login']) && !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = $bdd->prepare("SELECT password FROM utilisateurs WHERE login = :login");
    $query->execute(['login' => $login]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $count = $query->rowCount();
    if ($result = 1){
        $passwordBDD = $query->fetch(PDO::FETCH_ASSOC);
    if(password_verify($password,$passwordBDD['password'])){

        $sql2 = "SELECT * FROM utilisateurs WHERE login = :login";
        $query = $bdd->prepare($sql2);
        $query->execute(['login' => $login]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        $_SESSION = $user;
        header('location:index.php');
    }

    }
        else{
            $message = "Informations incorrectes !";
        }

}else{
    $message = "Vous avez rempli aucun des champs !  ";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php if(isset($_SESSION)){
    var_dump($_SESSION);

    if(empty($_SESSION)){ ?>
<h1> Connexion: </h1>
<form method="post">
    <label for="login">Login:</label>
    <input type="text" name="login">

    <label for="password">Password:</label>
    <input type="password" name="password">

    <input type="submit" name="submit" value="envoyer">
</form>
<?php }else {
    header('location:index.php');
}
}
?>
<?php if (!empty($message)){
    echo $message;
}
?>
<a href="index.php">Inscription</a>
</body>
</html>
