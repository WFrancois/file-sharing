<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 19/07/2017
 * Time: 01:28
 */

namespace FileSharing\Middleware;


use FileSharing\Service\Config;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

class ApiMiddleware
{
    /** @var  App */
    private $app;


    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        /** @var Config $config */
        $config = $this->app->getContainer()->get('config');

        if($config->isTokenValid($request->getParam('token'))) {
            return $next($request, $response);
        }

        return $response->withStatus(400);
    }
}