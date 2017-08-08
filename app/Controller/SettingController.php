<?php
/**
 * Created by PhpStorm.
 * User: isak
 * Date: 8/8/17
 * Time: 1:51 PM
 */

namespace FileSharing\Controller;


use Slim\Http\Request;
use Slim\Http\Response;

class SettingController extends BaseController
{
    public function editSettingsAction(Request $request, Response $response)
    {
        return $this->view->render($response, 'settings.html.twig', [
            'token' => $this->config->getToken(),
            'generateToken' => $this->router->pathFor('generateToken'),
            'keepFileName' => $this->config->keepFileName(),
            'changeKeepFileName' => $this->router->pathFor('changeKeepFileName'),
        ]);
    }

    public function generateToken(Request $request, Response $response)
    {
        $this->config->resetToken();

        return $response->withJson(['token' => $this->config->getToken()]);
    }

    public function changeKeepFileName(Request $request, Response $response)
    {
        $this->config->setKeepFileName($request->getParam('keepFileName', false) == 'true');

        return $response->withJson(['keepFileName' => $this->config->keepFileName()]);
    }
}