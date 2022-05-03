<?php

namespace Tsimashkou\CurrencyExchange\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    protected ScopeConfigInterface $_scopeConfig;
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
    }
    public function getStatus(){
        return $this->_scopeConfig->getValue('currencyexchange/general/choosecurrency', ScopeInterface::SCOPE_STORE);
    }

}
