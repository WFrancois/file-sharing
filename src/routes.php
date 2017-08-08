<?php
// Routes

$app->map(['GET', 'POST'], '/', \FileSharing\Controller\LoginController::class . ':initAction')->setName('initPage');

$app->get('/upload', \FileSharing\Controller\UploadController::class . ':uploadAction')->setName('uploadFile')
    ->add(new \FileSharing\Middleware\AuthMiddleware());

$app->post('/uploadAjax', \FileSharing\Controller\UploadController::class . ':uploadAjax')->setName('uploadAction')
    ->add(new \FileSharing\Middleware\AuthMiddleware());

$app->get('/logoff', \FileSharing\Controller\LoginController::class . ':logoffAction')->setName('logoff')
    ->add(new \FileSharing\Middleware\AuthMiddleware());


$app->group('/settings', function() {
    $this->get('', \FileSharing\Controller\SettingController::class . ':editSettingsAction')->setName('editSetting');

    $this->post('/generateToken', \FileSharing\Controller\SettingController::class . ':generateToken')->setName('generateToken');

    $this->post('/changeKeepFileName', \FileSharing\Controller\SettingController::class . ':changeKeepFileName')->setName('changeKeepFileName');

    $this->post('/changeMaxFileSize', \FileSharing\Controller\SettingController::class . ':changeMaxFileSize')->setName('changeMaxFileSize');
})
    ->add(new \FileSharing\Middleware\AuthMiddleware());

$app->group('/api', function() {
    $this->post('/sharex', \FileSharing\Controller\UploadController::class . ':uploadApiAction')->setName('uploadSharex');
})->add(new \FileSharing\Middleware\ApiMiddleware($app));