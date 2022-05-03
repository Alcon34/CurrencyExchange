<?php

namespace Tsimashkou\CurrencyExchange\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\StoreManagerInterface;
use Tsimashkou\CurrencyExchange\Helper\Data;


class CurrencyExchange extends Template
{
    protected Registry $_registry;
    private ResourceConnection $connection;
    protected Data $_helper;
    protected $_storeManager;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ResourceConnection $resourceConnection
     * @param Data $_helper
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(Context               $context,
                                Registry              $registry,
                                ResourceConnection    $resourceConnection,
                                Data                  $_helper,
                                StoreManagerInterface $storeManager)
    {
        $this->_registry = $registry;
        parent::__construct($context);
        $this->connection = $resourceConnection;
        $this->_helper = $_helper;
        $this->_storeManager = $storeManager;
    }

    /**
     * @return mixed|null
     */
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

    /**
     * @return float|int
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getBdCurrency()
    {
        // Текущая ставка
        $currentCode = $this->getCurrentCode();
        $sqlCurrentRate = 'SELECT cur_rate FROM tsimashkou_exchange_price WHERE cur_code="' . $currentCode . '"';
        $connectionCurrentRate = $this->connection->getConnection();
        $currentRate = 0;
        if ($connectionCurrentRate->fetchAll($sqlCurrentRate)) {
            $arrCurrentRate = $connectionCurrentRate->fetchAll($sqlCurrentRate);
            $currentRate = $arrCurrentRate[0]['cur_rate'];
        }
        // Ставка из кофигурации
        $settingCode = $this->getSettingCode();
        $sqlSettingRate = 'SELECT cur_rate FROM tsimashkou_exchange_price WHERE cur_code="' . $settingCode . '"';
        $connectionSettingRate = $this->connection->getConnection();
        $settingRate = 0;
        if ($connectionSettingRate->fetchAll($sqlSettingRate)) {
            $arrSettingRate = $connectionSettingRate->fetchAll($sqlSettingRate);
            $settingRate = $arrSettingRate[0]['cur_rate'];
        }

        if ($currentRate == 0) {
            return 0;
        } else {
            return $settingRate / $currentRate;
        }

        /*
         *
        //$tableName = $this->resourceConnection->getTableName('tsimashkou_exchange_price');
        $select = $connection->select()
            ->from(
                ['c' => $tableName],
                ['*']
            )
            ->where(
                "c.path = :path"
            )->where(
                "c.scope = :scope"
            );
        $bind = ['path'=>$path, 'scope'=>$scope];

        $records = $connection->fetchAll($select, $bind);
        */
        //$select = $connection->query($sql);

    }

    /**
     * @return mixed
     */
    public function getSettingCode()
    {
        $s = $this->_helper->getStatus();
        $id = (int)$s;
        $sql = "SELECT cur_code FROM tsimashkou_exchange_price WHERE id=$id";
        $connection = $this->connection->getConnection();
        $arrSettingCode = $connection->fetchAll($sql);
        return $arrSettingCode[0]['cur_code'];
    }

    /**
     * @return string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function getCurrentCode(): string
    {
        return $this->_storeManager->getStore()->getCurrentCurrency()->getCode();
    }

}
