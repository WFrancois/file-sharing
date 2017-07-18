<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 18/07/2017
 * Time: 23:08
 */

namespace FileSharing\Controller;


use Slim\Http\Request;
use Slim\Http\Response;

class UploadController extends BaseController
{
    public function uploadAction(Request $request, Response $response)
    {
        echo 't';
    }
}