<?php

namespace FileSharing\Controller;


use Slim\Http\Request;
use Slim\Http\Response;

class LoginController extends BaseController
{
    public function initAction(Request $request, Response $response)
    {
        if($this->config->userDefined()) {
            if(!empty($_SESSION['logged'])) {
                $url = $this->router->pathFor('uploadFile');
                return $response->withStatus(302)->withHeader('Location', $url);
            }
            return $this->login($request, $response);
        } else {
            return $this->defineUser($request, $response);
        }
    }

    private function login(Request $request, Response $response)
    {
        if($request->getMethod() === 'POST') {
            $username = $request->getParam('username');
            $password = $request->getParam('password');

            if(!empty($username) && !empty($password)) {
                if($this->config->userValid($username, $password)) {
                    $_SESSION['username'] = $username;
                    $_SESSION['logged'] = true;

                    $url = $this->router->pathFor('uploadFile');
                    return $response->withStatus(302)->withHeader('Location', $url);
                }
            }
        }

        return $this->view->render($response, 'login.html.twig');
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

    public function logoffAction(Request $request, Response $response)
    {
        unset($_SESSION['username']);
        unset($_SESSION['logged']);

        $url = $this->router->pathFor('initPage');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}