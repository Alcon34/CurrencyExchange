<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Tsimashkou\CurrencyExchange\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/fixer/{date}?symbols={symbols}&base={base}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: oDu7rJ3O5L0FV7Ea7kH0Rxkn0H16QopB"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;

        $installer = $setup;
        $installer->startSetup();

        /** Add base rate */
        $sampleTemplates = [
            'id'           => '1',
            'cur_code'     => 'USD',
            'cur_rate'     => 2.78
        ];

        $setup->getConnection()->insert($setup->getTable('tsimashkou_exchange_price'), $sampleTemplates);

        $installer->endSetup();
    }
}
