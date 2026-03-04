<?php
error_reporting(E_ERROR | E_PARSE);

require 'vendor/autoload.php';

use OpenApi\Generator;
use OpenApi\Attributes as OA;

#[OA\Info(title: "My Simple API", version: "1.0.0")]
class OpenApiConfig {}

class HelloController {

    #[OA\Get(
        path: "/hello",
        operationId: "helloWorld",
        responses: [
            new OA\Response(response: 200, description: "Returns Hello World")
        ]
    )]
    public function helloWorld()
    {
        header('Content-Type: application/json');
        echo json_encode(["message" => "Hello World"]);
    }
}

$requestUri = strtok($_SERVER['REQUEST_URI'], '?');

$controller = new HelloController();

if ($requestUri === '/hello') {
    $controller->helloWorld();
    exit;
}

if ($requestUri === '/docs') {
    $openapi = Generator::scan([__FILE__]);
    header('Content-Type: application/json');
    echo $openapi->toJson();
    exit;
}

header('Content-Type: text/plain');
echo "Available endpoints: /hello, /docs";
