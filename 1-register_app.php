<?php

require 'mastophp/autoload.php';

// Setting up your instance
$mastoPHP = new MastoPHP\MastoPHP('@aka@instance.tld');

// Setting up your App name and your website
$app = $mastoPHP->registerApp('MastoPHP', 'https://www.stefofficiel.me');
if ( $app === false) {
    throw new Exception('Problem during register app');
}

echo $app->getAuthUrl();

// Copy this URL and open it.
// Allow App to use Mastodon and copy the given token