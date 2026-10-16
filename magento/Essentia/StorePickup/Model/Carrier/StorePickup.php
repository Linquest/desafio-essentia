<?php

declare(strict_types=1);

namespace Essentia\StorePickup\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;

class StorePickup extends AbstractCarrier implements CarrierInterface
{
    protected $_code = 'essentia_storepickup';

    protected $_isFixed = true;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        private readonly ResultFactory $rateResultFactory,
        private readonly MethodFactory $rateMethodFactory,
        array $data = []
    ) {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    public function collectRates(RateRequest $request): Result|false
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $method = $this->rateMethodFactory->create();

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));
        $method->setMethod('pickup');
        $method->setMethodTitle($this->getConfigData('name'));
        $method->setPrice(0.00);
        $method->setCost(0.00);

        $result = $this->rateResultFactory->create();
        $result->append($method);

        return $result;
    }

    public function getAllowedMethods(): array
    {
        return ['pickup' => $this->getConfigData('name')];
    }
}
