<?php
// Routes

$app->get('/', function(\Slim\Http\Request $request, \Slim\Http\Response $response) {
    $url = $this->router->pathFor('initPage');
    return $response->withStatus(302)->withHeader('Location', $url);
});

$app->group('/config', function () {
    $this->map(['GET', 'POST'], '/', \FileSharing\Controller\LoginController::class . ':initAction')->setName('initPage');
});