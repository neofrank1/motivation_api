<?php 

namespace Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class QuotesController {

    public $apiKey;
    public $curl;

    public function __construct() {
        $this->curl = curl_init();
    }

    public function getQuotes(Request $request, Response $response) {

        if ($request->getMethod() !== 'GET') {
            $response->getBody()->write(json_encode(["error" => "Method Not Allowed"]));
            return $response->withStatus(405)->withHeader('Content-Type', 'application/json');
        }

        $apiKey = $_ENV['RAPIDAPI_KEY'] ?? null;
        if (empty($apiKey)) {
            $response->getBody()->write(json_encode(["error" => "RAPIDAPI_KEY environment variable is not set"]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }

        curl_setopt_array($this->curl, [
            CURLOPT_URL => "https://chat-gpt26.p.rapidapi.com/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'model' => 'GPT-5-mini',
                'messages' => [
                        [
                            'role' => 'user',
                            'content' => 'Can you give me a life advice quote? Just give me the quote, no other text. just one quote and one liner'
                        ]
                ]
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "x-rapidapi-host: chat-gpt26.p.rapidapi.com",
                "x-rapidapi-key: " . $apiKey
            ],
        ]);
        
        $responseData = curl_exec($this->curl);
        $err = curl_error($this->curl);
        
        curl_close($this->curl);
        
        if ($err) {
            $response->getBody()->write(json_encode(["error" => "cURL Error #:" . $err]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        } else {
            $decodedResponse = json_decode($responseData, true);
            $message = isset($decodedResponse['choices'][0]['message']['content']) 
                ? $decodedResponse['choices'][0]['message']['content'] 
                : null;
            
            if ($message === null) {
                $response->getBody()->write(json_encode(["error" => "Unable to extract message from response"]));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
            
            $response->getBody()->write(json_encode(["quote" => $message]));
            return $response->withHeader('Content-Type', 'application/json');
        }
        
        return $response;
    }

    public function test(Request $request, Response $response)
    {
       $response->getBody()->write("Quotes Controller is working!");
       return $response;
    }

}
