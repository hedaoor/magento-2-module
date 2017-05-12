<?php

namespace Rahul\Outofstock\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'grid_banner'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('outofstocksubscription_info')
        )
        ->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true,'auto_increment' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'ID'
        )
        ->addColumn(
            'product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
           ['nullable' => false, 'unsigned' => true, 'primary' => false],
            'product_id'
        )
        ->addColumn(
            'email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            200,
            ['nullable' => false, 'default' => ''],
            'Email'
        )
        ->addColumn(
            'requested_qty',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
             ['nullable' => false, 'primary' => false],
            'Requested Qty'
        )
        ->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
             ['nullable' => false, 'primary' => false],
            'Is Active'
        )
        ->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
            null,
            ['nullable' => false],
            'Created At'
        )
        ->addForeignKey(
            $installer->getFkName(
                'outofstocksubscription_info',
                'product_id',
                'catalog_product_entity',
                'entity_id'
            ),
            'product_id', $installer->getTable('catalog_product_entity'), 'entity_id',
            \Magento\Framework\Db\Ddl\Table::ACTION_CASCADE
        )
        /*{{CedAddTableColumn}}}*/
        
        
        ->setComment(
            'Out of stock subscription table'
        );
        
        $installer->getConnection()->createTable($table);
        /*{{CedAddTable}}*/

        $installer->endSetup();

        // $installer->endSetup();

    }
}