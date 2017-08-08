<?php

$container = $app->getContainer();

$container['config'] = function ($c) {
    $config = new \FileSharing\Service\Config(__DIR__ . '/../config/config.yaml');

    return $config;
};

$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../templates', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    $view->getEnvironment()->addGlobal('session', $_SESSION);
    $view->getEnvironment()->addGlobal('config', $c->config);
    $view->getEnvironment()->addGlobal('currentUrl', $c['request']->getUri()->getPath());

    return $view;
};