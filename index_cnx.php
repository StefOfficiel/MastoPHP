<?php
// Exemple d'utilisation :
// Vous devez aussi configurer MastoPHP.php
// en remplaçant "urn:ietf:wg:oauth:2.0:oob" par "https://votre_site.tld/index_cnx.php" ici, index.php fait référence à ce présent fichier
//
// Votre formulaire initial où vous allez demander le @aka@instance.tld doit renvoyer cette valeur à index_cnx.php?i=@aka@instance.tld

session_start();

if((($_SESSION['akainstance'] == "") || (empty($_SESSION['akainstance']))) && (htmlspecialchars($_GET['i']) != "")){
    $akainstance = htmlspecialchars($_GET['i']);
    $_SESSION['akainstance'] = $akainstance;
}

$full_instance = $_SESSION['akainstance'];

require './mastophp/autoload.php';

$mastoPHP = new MastoPHP\MastoPHP(''.$akainstance.'');

$app = $mastoPHP->registerApp('YourAppName', 'http://my-website.com');

if(!empty($_GET['i'])){
    if($app === false) {
        throw new Exception('Problem during register app');
    }

    // Redirection automatique vers l'instance pour validation
    header('location:'.$app->getAuthUrl().'');
}

if(!empty($_GET['code'])){

    // L'instance renvoie à index_cnx.php le code par la méthode get : https://votre_site.tld/index_cnx.php?code=XXXXXXX
    $app->registerAccessToken(''.htmlspecialchars($_GET['code']).'');

$user = $app->getUser();

// Ceci est facultatif, mais vous pouvez enregistrer les éléments récupérés en session
$_SESSION['username'] = $user['username'];
$_SESSION['display_name'] = $user['display_name'];
$_SESSION['avatar'] = $user['avatar'];
$_SESSION['uid'] = $user['id'];

// Redirigez ensuite où vous le souhaitez, à cette étape, l'utilisateur·rice est connecté·e via son compte Mastodon.
header('location: ./index.php');

//var_dump($app->getUser());

//var_dump($app->getFavourites());

//var_dump($app->getAccount(1629));

//var_dump($app->getFollowers(1629));

//var_dump($app->getFollowing(1629));

//var_dump($app->postStatus('This status is posted by #PHP'));

//var_dump($app->getStatuses('1629', ['only_media' => true]));

//var_dump($app->getStatuses('1629'));

//var_dump($app->getFollowers(1629, ['limit' => 5]));
