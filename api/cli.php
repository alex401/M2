<?php
require 'vendor/autoload.php';



include 'middleware.php';



if (PHP_SAPI == 'cli') {

  echo "Entering CLI mode ";
    $argv = $GLOBALS['argv'];
    array_shift($argv);
    var_dump($argv);

    $pathInfo = implode('/', $argv);


    $settings = require 'settings.php';
    $app = new \Slim\App($settings);

    $app->add(new App\Middleware\CliRequest());


    $app->map(['GET'], 'import', function() {
      echo "import";
       // do import
    });

    $app->get('/status', 'PHPMinds\Action\EventStatusAction:dispatch')
    ->setName('status');
}
