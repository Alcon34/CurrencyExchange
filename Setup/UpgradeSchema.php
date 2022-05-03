<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Tsimashkou\CurrencyExchange\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Zend_Db_Exception;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @inheritdoc
     * @throws Zend_Db_Exception
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.8.0', '<')) {
            if (!$installer->tableExists('tsimashkou_exchange_price')) {
                $table = $installer->getConnection()
                    ->newTable($installer->getTable('tsimashkou_exchange_price'))
                    ->addColumn('id', Table::TYPE_INTEGER, null, [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ], 'ID')
                    ->addColumn('cur_code', Table::TYPE_TEXT, null, [
                        'length' => 8,
                    ], 'Currency code')
                    ->addColumn('cur_rate', Table::TYPE_FLOAT, [], 'Currency rate');
                $installer->getConnection()->createTable($table);
            }
        }

        $installer->endSetup();
    }
}
