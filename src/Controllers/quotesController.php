<?php 

namespace Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class QuotesController {

    public function test(): bool
    {
       echo "Quotes Controller is working!";
       return true;
    }

}
