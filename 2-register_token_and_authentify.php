<?php

require 'mastophp/autoload.php';

$mastoPHP = new MastoPHP\MastoPHP('@aka@instance.tld');

$app = $mastoPHP->registerApp('MastoPHP', 'https://www.stefofficiel.me');
if ( $app === false) {
    throw new Exception('Problem during register app');
}

$token = $app->registerAccessToken('write_here_your_token_got_in_step_1');

$bearer_token = $app->authentify("your_email@mail.com", "Your_Password");

// Now Token is registered in JSON file