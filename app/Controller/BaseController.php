<?php

namespace FileSharing\Controller;


use Slim\Container;
use Slim\Views\Twig;

class BaseController
{
    /** @var Twig */
    protected $view;

    public function __construct(Container $container)
    {
        $this->view = $container->view;
    }
}