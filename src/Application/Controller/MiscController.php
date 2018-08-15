<?php
namespace Refactor\Application\Controller;

use Refactor\Common\Controller\AbstractController;
use Refactor\Common\Response\ResponseFactory;
use Refactor\Common\Response\ResponseInterface;

class MiscController extends AbstractController
{
    public function pageNotFound()
    {
        return ResponseFactory::createResponse(ResponseInterface::CODE_NOT_FOUND, 'Not Found');
    }

    public function methodOptions()
    {
        $Response = ResponseFactory::createResponse(ResponseInterface::CODE_NO_CONTENT);
        $Response->setHeaders(
            [
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Headers' => 'X-Requested-With, X-HTTP-Method-Override, Content-Type, Accept',
            ]
        );

        return $Response;
    }
}
