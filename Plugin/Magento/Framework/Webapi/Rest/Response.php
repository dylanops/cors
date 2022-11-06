<?php

declare(strict_types=1);

namespace DylanOps\CORS\Plugin\Magento\Framework\Webapi\Rest;

use DylanOps\CORS\Helper\HeaderManager;

class Response
{
    /** @var HeaderManager  */
    private HeaderManager $headerManager;

    public function __construct(HeaderManager $headerManager)
    {
        $this->headerManager = $headerManager;
    }

    /**
     * @param $subject
     * @return void
     */
    public function beforeSendResponse($subject): void
    {
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class);
        $logger->log(1, "============> File Response.php");

        $this->headerManager->applyHeaders($subject);
    }

}
