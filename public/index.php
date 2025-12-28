<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Load routes
(require __DIR__ . '/../src/Routes/routes.php')($app);

$app->run();