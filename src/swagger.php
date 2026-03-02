<?php
/*
  apt update
  apt install -y nodejs npm
  apt install -y git
  npm install swagger-ui-dist
  mkdir swagger-ui
  cp -r node_modules/swagger-ui-dist/* swagger-ui/
  swagger-ui dizininde petstore.swagger.io ara ve onu http://localhost/docsiledeğiştir
*/
error_reporting(E_ERROR | E_PARSE);

require 'vendor/autoload.php';

use OpenApi\Generator;
use OpenApi\Attributes as OA;

#[OA\Info(title: "My Simple API", version: "1.0.0")]
class OpenApiConfig {}

// Basit bir endpoint tanımı
#[OA\Get(
    path: "/hello",
    operationId: "helloWorld",
    responses: [
        new OA\Response(response: 200, description: "Returns Hello World")
    ]
)]
function helloWorld() {
    header('Content-Type: application/json');
    echo json_encode(["message" => "Hello World"]);
}

// Router mantığı
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/hello') {
    helloWorld();
    exit;
}

if ($requestUri === '/docs') {
    // Swagger dokümantasyonu üret
    $openapi = Generator::scan([__DIR__ . '/swagger.php']);
    header('Content-Type: application/json');
    echo $openapi->toJson();
    exit;
}

// Varsayılan cevap
header('Content-Type: text/plain');
echo "Available endpoints: /hello, /docs";
