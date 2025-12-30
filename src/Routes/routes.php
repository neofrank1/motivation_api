<?php 

use Controllers\QuotesController;

return function($app) {
    $app->get('/', [QuotesController::class, 'test']);
    $app->get('/quotes', [QuotesController::class, 'getQuotes']);
};