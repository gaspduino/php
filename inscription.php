<?php

$servername = 'localhost';
$username = 'admin';
$password = 'gaspduino';
$dbname = 'espace_membres';
$bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['form']))
echo "ok1";
$pseudo = htmlspecialchars($_POST['pseudo']);
$mail = htmlspecialchars($_POST['mail']);
$mail2 = htmlspecialchars($_POST['mail2']);
$mdp = sha1($_POST['mdp']);
$mdp2 = sha1($_POST['mdp2']);
if (!empty($_POST['pseudo']) and !empty($_POST['mail']) and !empty($_POST['mail2']) and !empty($_POST['mdp']) and !empty($_POST['mdp2'])) {


    $psudolength = strlen($pseudo);
    if ($psudolength <= 255) {
        if ($mail == $mail2) {
            if ($mdp == $mdp2) {
                if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail= ?");
                    $reqmail->execute(array($mail));
                    $mailexist = $reqmail->rowCount();
                    if ($mailexist == 0) {


                        $sql = "INSERT INTO membres (pseudo, mail, motdepasse) VALUES ('$pseudo' , '$mail', '$mdp' )";
                        $bdd->exec($sql);
                        $erreur = "Création réussite! ";
                    } else {
                        $erreur = 'Votre adresse mail est déjà utilisée!';
                    }
                } else {
                    $erreur = "Votre adresse mail n'est pas valide!";
                }
            } else {
                $erreur = "Vos mots de passes ne correspondent pas!";
            }


        } else {
            $erreur = "Vos adresses mail ne correspondent pas!";
        }

    } else {
        $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
    }
} else {
    $erreur = "Tous les champs doivent être complétés!";

}


?>
<html>
<head>
    <title>Gaspduino</title
    <meta charset="UTF-8">
</head>
<body>
<div align="center">
    <h2>Inscription</h2>
    <br><br>
    <form method="post" action="">
        <table>
            <tr>
                <td>
                    <label for="pseudo">Pseudo:</label>
                </td>
                <td>
                    <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo">
                </td>
            <tr>
                <td>
                    <label for="mail">Mail:</label>
                </td>
                <td>
                    <input type="email" placeholder="Votre mail" id="mail" name="mail">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mail2">Confirmation du mail :</label>
                </td>
                <td>
                    <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mdp">Mot de passe :</label>
                </td>
                <td>
                    <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mdp2">Confirmation du mot de passe :</label>
                </td>
                <td>
                    <input type="password" placeholder="Confirmez  votre mdp" id="mdp2" name="mdp2">
                </td>
            </tr>
            <tr>
                <td></td>
                <td align="center">
                    <br>
                    <input type="submit" name="form" value="Je m'inscris">
                </td>
            </tr>
        </table>
        <?php
        if (isset($erreur)) {
            echo '<strong>' . $erreur . '</strong>';
        }
        ?>
</div>
</body>
</html>