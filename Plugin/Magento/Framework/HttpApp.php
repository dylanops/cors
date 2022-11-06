<?php

declare(strict_types=1);

namespace DylanOps\CORS\Plugin\Magento\Framework;

use Magento\Framework\App\AreaList;
use Magento\Framework\App\Request\Http as RequestHttp;
use Magento\Framework\App\State;
use Magento\Framework\ObjectManager\ConfigLoaderInterface;
use Magento\Framework\ObjectManagerInterface;

class HttpApp
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var AreaList
     */
    private $areaList;

    /**
     * @var ConfigLoaderInterface
     */
    private $configLoader;

    /**
     * @var State
     */
    private $state;

    /**
     * @var RequestHttp
     */
    private $request;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param AreaList $areaList
     * @param RequestHttp $request
     * @param ConfigLoaderInterface $configLoader
     * @param State $state
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        AreaList $areaList,
        RequestHttp $request,
        ConfigLoaderInterface $configLoader,
        State $state
    ) {
        $this->objectManager = $objectManager;
        $this->areaList = $areaList;
        $this->configLoader = $configLoader;
        $this->state = $state;
        $this->request = $request;
    }

    /**
     * @param \Magento\Framework\AppInterface $subject
     * @param callable $proceed
     * @return \Magento\Framework\App\Response\Http|\Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function aroundLaunch(\Magento\Framework\AppInterface $subject, callable $proceed)
    {
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class);
        $logger->log(1, "============> File HttpApp.php");

        if ($this->request->getMethod() === RequestHttp::METHOD_OPTIONS) {
            $logger->log(1, "is Options");

            $areaCode = $this->areaList->getCodeByFrontName($this->request->getFrontName());
            $this->state->setAreaCode($areaCode);
            $this->objectManager->configure($this->configLoader->load($areaCode));
            /** @var \DylanOps\CORS\Controller\OptionsController::class */
            $controller = $this->objectManager->get(\DylanOps\CORS\Controller\OptionsController::class);
            $response = $controller->dispatch($this->request);
            return $response;
        }

        $logger->log(1, "not Options");
        return $proceed();
    }
}
