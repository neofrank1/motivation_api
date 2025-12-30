<?php 

namespace Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class QuotesController {

    public function getQuotes(Request $request, Response $response) {

        if ($request->getMethod() !== 'GET') {
            $response->getBody()->write(json_encode(["error" => "Method Not Allowed"]));
            return $response->withStatus(405)->withHeader('Content-Type', 'application/json');
        }
        
        $response->getBody()->write(json_encode([
            ["quote" => "The only limit to our realization of tomorrow is our doubts of today.", "author" => "Franklin D. Roosevelt"],
            ["quote" => "In the middle of every difficulty lies opportunity.", "author" => "Albert Einstein"],
            ["quote" => "What you get by achieving your goals is not as important as what you become by achieving your goals.", "author" => "Zig Ziglar"]
        ]));
        $response->withHeader('Content-Type', 'application/json');
        
        return $response;
    }

    public function test(Request $request, Response $response)
    {
       $response->getBody()->write("Quotes Controller is working!");
       
       return $response;
    }

}
