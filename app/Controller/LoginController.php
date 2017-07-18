<?php

namespace FileSharing\Controller;


use Slim\Http\Request;
use Slim\Http\Response;

class LoginController extends BaseController
{
    public function initAction(Request $request, Response $response)
    {
        if($this->config->userDefined()) {
            return $this->login($request, $response);
        } else {
            return $this->defineUser($request, $response);
        }
    }

    private function login(Request $request, Response $response)
    {
    }

    private function defineUser(Request $request, Response $response)
    {
        if($request->getMethod() === 'POST') {
            $username = $request->getParam('username');
            $password = $request->getParam('password');

            if(!empty($username) && !empty($password)) {
                $this->config->setUser($username, $password);

                $url = $this->router->pathFor('initPage');
                return $response->withStatus(302)->withHeader('Location', $url);
            }
        }

        return $this->view->render($response, 'initConfig.html.twig');
    }
}