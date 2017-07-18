<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 18/07/2017
 * Time: 23:08
 */

namespace FileSharing\Controller;


use FileSharing\Service\Util;
use Slim\Http\Request;
use Slim\Http\Response;

class UploadController extends BaseController
{
    public function uploadAction(Request $request, Response $response)
    {
        $url = $this->router->pathFor('uploadAction');

        return $this->view->render($response, 'upload.html.twig', [
            'routeUpload' => $url,
        ]);
    }

    public function uploadAjax(Request $request, Response $response)
    {
        $uploaddir = __DIR__ . '/../../public/f/';

        if (empty($_FILES['file'])) {
            return $response->withStatus(400, 'Error: the file size may be over the limit');
        }

        if(!is_dir($uploaddir)) {
            return $response->withStatus(400, 'Directory doesn\'t exist');
        }

        if(!is_writable($uploaddir)) {
            return $response->withStatus(400, 'Directory isn\'t writable.');
        }

        do {
            $fileName = Util::generateRandomString(5) . '_' . basename($_FILES['file']['name']);
        } while(file_exists($uploaddir . $fileName));

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . $fileName)) {
            return $response->withJson(['url' => '/f/' . $fileName])->withStatus(201);
        }

        return $response->withStatus(400);
    }
}