<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/UserController.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Middleware para JSON Response
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Instância do Controller
$userController = new UserController();

// Rotas
$app->get('/users', [$userController, 'getUsers']);
$app->post('/users', [$userController, 'createUser']);
$app->put('/users/{id}', [$userController, 'updateUser']);
$app->delete('/users/{id}', [$userController, 'deleteUser']);

$app->run();
?>
