<?php

require 'mastophp/autoload.php';

$mastoPHP = new MastoPHP\MastoPHP('@aka@instance.tld');

$app = $mastoPHP->registerApp('MastoPHP', 'https://www.stefofficiel.me');
if ( $app === false) {
    throw new Exception('Problem during register app');
}

//var_dump($app->getUser());

//var_dump($app->getFavourites());

//var_dump($app->getAccount(1629));

//var_dump($app->getFollowers(1629));

//var_dump($app->getFollowing(1629));

//var_dump($app->postStatus('This status is posted by #PHP'));

//var_dump($app->getStatuses('1629', ['only_media' => true]));

//var_dump($app->getStatuses('1629'));

//var_dump($app->getFollowers(1629, ['limit' => 5]));
