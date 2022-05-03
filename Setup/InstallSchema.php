<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Tsimashkou\CurrencyExchange\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @inheritdoc
     * @throws Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (!$installer->tableExists('tsimashkou_exchange_price')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('tsimashkou_exchange_price'))
                ->addColumn('id', Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ], 'ID')
                ->addColumn('cur_code', Table::TYPE_TEXT, null, [
                    'length' => 8,
                ], 'Currency code')
                ->addColumn('cur_rate', Table::TYPE_FLOAT, null, [
                    'nullable' => true
                ], 'Currency rate')
                ->setComment('Currency exchange');

            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
