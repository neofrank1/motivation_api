<?php 

use Controllers\quotesController;

return function($app) {
    $app->get('/', [quotesController::class, 'test']);
    $app->get('/quotes', [quotesController::class, 'getQuotes']);
};