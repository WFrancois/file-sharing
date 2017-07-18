<?php

namespace FileSharing\Controller;


use FileSharing\Service\Config;
use Slim\Container;
use Slim\Router;
use Slim\Views\Twig;

class BaseController
{
    /** @var Twig */
    protected $view;

    /** @var Config */
    protected $config;

    /** @var Router */
    protected $router;

    public function __construct(Container $container)
    {
        $this->view = $container->view;
        $this->config = $container->config;
        $this->router = $container->router;
    }
}