<?php
// Routes

$app->get('/', function(\Slim\Http\Request $request, \Slim\Http\Response $response) {
    $url = $this->router->pathFor('initPage');
    return $response->withStatus(302)->withHeader('Location', $url);
});

$app->group('/config', function () {
    $this->map(['GET', 'POST'], '/', \FileSharing\Controller\LoginController::class . ':initAction')->setName('initPage');

    $this->get('/upload', \FileSharing\Controller\UploadController::class . ':uploadAction')->setName('uploadFile')
        ->add(new \FileSharing\Middleware\AuthMiddleware());

    $this->post('/uploadAjax', \FileSharing\Controller\UploadController::class . ':uploadAjax')->setName('uploadAction')
        ->add(new \FileSharing\Middleware\AuthMiddleware());

    $this->get('/logoff', \FileSharing\Controller\LoginController::class . ':logoffAction')->setName('logoff')
        ->add(new \FileSharing\Middleware\AuthMiddleware());
});