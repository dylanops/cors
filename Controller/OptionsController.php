<?php

declare(strict_types=1);

namespace DylanOps\CORS\Controller;

use DylanOps\CORS\Helper\HeaderManager;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\Http as ResponseHttp;
use Magento\Framework\App\ResponseInterface;

class OptionsController
{

    /** @var ResponseHttp  */
    private ResponseHttp $response;

    /** @var HeaderManager  */
    private HeaderManager $headerManager;

    public function __construct(
        ResponseHttp $response,
        HeaderManager $headerManager
    ) {
        $this->response = $response;
        $this->headerManager = $headerManager;
    }

    /**
     * Dispatch application action
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class);
        $logger->log(1, "============> File OptionsController.php");
        $logger->log(1, $request->getActionName());

        $this->headerManager->applyHeaders($this->response);
        return $this->response;
    }
}
