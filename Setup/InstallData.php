<?php


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
