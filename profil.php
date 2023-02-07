<?php
session_start();

$servername = 'localhost';
$username = 'admin';
$password = 'gaspduino';
$dbname = 'espace_membres';
$bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_GET['id']) AND $_GET['id'] > 0){
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
?>
    <html>
<head>
    <title>Gaspduino</title
    <meta charset="UTF-8">
</head>
<body>
<div align="center">
    <h2>Profil de <?php echo $userinfo['pseudo'] ?> </h2>
    <br><br>
    Pseudo =<?php echo $userinfo['pseudo'] ?>
    <br>
    Mail =<?php echo $userinfo['mail'] ?>
    <br>
   <?php
    if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']){
        ?>
        <a href="#">Editer mon profil</a>
        <a href="deconnection.php">Se déconnecter</a>
        <?php
    }
?>
</div>
</body>
    </html>
<?php
}
else{
}
?>