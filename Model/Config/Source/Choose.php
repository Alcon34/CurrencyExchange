<?php

namespace Tsimashkou\CurrencyExchange\Model\Config\Source;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Option\ArrayInterface;

class Choose implements ArrayInterface
{
    private ResourceConnection $connection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->connection = $resourceConnection;
    }

    public function GetBdCurrency(): array
    {
        $sql = 'SELECT cur_code FROM tsimashkou_exchange_price';
        $connection = $this->connection->getConnection();
        return $connection->fetchAll($sql);
    }

    public function toOptionArray()
    {
        $option_arr = $this->GetBdCurrency();
        $attributesArrays = array();
        for ($i = 0; $i < count($option_arr); $i++) {
            $attributesArrays[$i] = array(
                'label' => $option_arr[$i]['cur_code'],
                'value' => $i+1
            );
        }
        return $attributesArrays;

    }

}
