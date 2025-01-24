<?php

require 'vendor/autoload.php';

Flight::route('/', function () {
  echo 'bonjour le monde!';
});

Flight::start();