<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 18/07/2017
 * Time: 23:08
 */

namespace FileSharing\Controller;


use FileSharing\Exception\UploadFileException;
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
        if (empty($_FILES['file'])) {
            return $response->withStatus(400, 'Error: the file size may be over the limit');
        }

        try {
            $filename = $this->uploadFile($_FILES['file']);

            return $response->withJson(['url' => Util::getBaseUrl() . $filename])->withStatus(201);
        } catch (UploadFileException $ufe) {
            return $response->withStatus(400, $ufe->getMessage());
        }
    }

    public function uploadApiAction(Request $request, Response $response)
    {
        if (empty($_FILES['sharex'])) {
            return $response->withStatus(400, 'Error: the file size may be over the limit');
        }

        try {
            $filename = $this->uploadFile($_FILES['sharex']);

            return $response->withJson([
                'success' => true,
                'link' => Util::getBaseUrl() . $filename,
            ])->withStatus(201);
        } catch (UploadFileException $ufe) {
            return $response->withStatus(400, $ufe->getMessage());
        }
    }

    private function uploadFile($file)
    {
        $uploaddir = __DIR__ . '/../../public/f/';

        if (!is_dir($uploaddir)) {
            mkdir($uploaddir);

            if (!is_writable($uploaddir)) {
                throw new UploadFileException('Directory isn\'t writable.');
            }
        }

        if (!is_writable($uploaddir)) {
            throw new UploadFileException('Directory doesn\'t exist');
        }

        $name = explode('.', basename($file['name']));
        $baseName = $name[0];
        unset($name[0]);
        $extension = implode('.', $name);
        if(!empty($extension)) {
            $extension = '.' . $extension;
        }

        do {
            if($this->config->keepFileName()) {
                $fileName = Util::generateRandomString(5) . '_' . $baseName . $extension;
            } else {
                $fileName = Util::generateRandomString(10) . $extension;
            }
        } while (file_exists($uploaddir . $fileName));

        if (move_uploaded_file($file['tmp_name'], $uploaddir . $fileName)) {
            return '/f/' . $fileName;
        }

        throw new UploadFileException('Error');
    }
}