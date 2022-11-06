<?php

declare(strict_types=1);

namespace DylanOps\CORS\Helper;

class HeaderManager
{
    public function applyHeaders(\Magento\Framework\App\Response\HttpInterface $response): void
    {
        $response->setHeader("Connection", "keep-alive");
        $response->setHeader("Access-Control-Allow-Origin", "*");
        $response->setHeader("Access-Control-Allow-Methods", "POST, GET, OPTIONS, DELETE");
        $response->setHeader("Access-Control-Max-Age", "86400");
    }
}
