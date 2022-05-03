<?php

namespace Tsimashkou\CurrencyExchange\Model\Config\Source;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Option\ArrayInterface;

class Choose implements ArrayInterface
{
    private ResourceConnection $connection;

    /**
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->connection = $resourceConnection;
    }

    /**
     * @return array
     */
    public function GetBdCurrency(): array
    {
        $sql = 'SELECT cur_code FROM tsimashkou_exchange_price';
        $connection = $this->connection->getConnection();
        return $connection->fetchAll($sql);
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $optionArr = $this->GetBdCurrency();
        $attributesArrays = array();
        for ($i = 0; $i < count($optionArr); $i++) {
            $attributesArrays[$i] = array(
                'label' => $optionArr[$i]['cur_code'],
                'value' => $i+1
            );
        }
        return $attributesArrays;

    }

}
