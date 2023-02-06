<?php
session_start();

$servername = 'localhost';
$username = 'admin';
$password = 'gaspduino';
$dbname = 'espace_membres';
$bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['formconnexion'])) {
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = sha1($_POST['mdpconnect']);

    if (!empty($mailconnect) and !empty($mdpconnect)) {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ? ");
        $requser->execute(array($mailconnect, $mdpconnect));
        $userexist = $requser->rowCount();

        if ($userexist == 1) {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            header("Location: profil.php?id=".$_SESSION['id']);
        }else{
            $erreur = "Mauvais mail ou mot de passe!";
        }

    } else {
        $erreur = "Tous les champs doivent être complétés!";
    }
}

?>
<html>
<head>
    <title>Gaspduino</title
    <meta charset="UTF-8">
</head>
<body>
<div align="center">
    <h2>Connection</h2>
    <br><br>
    <form method="post" action="">
        <input type="email" name="mailconnect" placeholder="Mail">
        <input type="password" name="mdpconnect" placeholder="Mot de passe">
        <input type="submit" name="formconnexion" value="Se connecter">
    </form>
    <?php
    if (isset($erreur)) {
        echo '<strong>' . $erreur . '</strong>';
    }
    ?>
</div>
</body>
</html>