<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 18/07/2017
 * Time: 23:05
 */

namespace FileSharing\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        if(!empty($_SESSION['logged'])) {
            return $next($request, $response);
        }

        return $response->withRedirect('/');
    }
}