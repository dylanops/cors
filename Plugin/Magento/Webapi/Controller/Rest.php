<?php

declare(strict_types=1);

namespace DylanOps\CORS\Plugin\Magento\Webapi\Controller;

use DylanOps\CORS\Helper\HeaderManager;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\Http as HttpResponse;
use Magento\Webapi\Controller\Rest as RestController;

class Rest
{

    /** @var HttpResponse */
    private HttpResponse $response;

    /** @var HeaderManager  */
    private HeaderManager $headerManager;

    public function __construct(HttpResponse $response, HeaderManager $headerManager)
    {
        $this->response = $response;
        $this->headerManager = $headerManager;
    }

    /**
     * @param RestController $subject
     * @param callable $next
     * @param RequestInterface $request
     * @return string
     */
    public function aroundDispatch(RestController $subject, callable $next, RequestInterface $request)
    {
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class);
        $logger->log(1, "============> File Rest.php");
        $logger->log(1, $request->getActionName());

        if ($request instanceof Http && $request->isOptions()) {
            $logger->log(1, "is options");

            $this->headerManager->applyHeaders($this->response);
            $this->response->setPublicHeaders(86400);
            return $this->response;

        }

        $logger->log(1, "not options");
        /** @var HttpResponse $response */
        return $next($request);
    }
}
