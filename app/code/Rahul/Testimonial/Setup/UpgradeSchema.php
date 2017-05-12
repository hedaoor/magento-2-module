<?php

namespace Rahul\Testimonial\Setup;
 
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $tableName = $setup->getTable('testimonials');
        //handle all possible upgrade versions
 
        if(!$context->getVersion()) {
            //no previous version found, installation, InstallSchema was just executed
            //be careful, since everything below is true for installation !
        }
 
        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            //code to upgrade to 1.0.1
            if ($setup->getConnection()->isTableExists($tableName) == true) {

                $setup->getConnection()->addColumn(
                $setup->getTable('testimonials'),
                    'avtar',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, // Or any other type
                        'nullable' => true, // Or false
                        'comment' => 'Avtar',
                        'after' => 'email'
                    ]
                );

                $setup->getConnection()->addColumn(
                $setup->getTable('testimonials'),
                    'website',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, // Or any other type
                        'nullable' => true, // Or false
                        'comment' => 'Website',
                        'after' => 'avtar'
                    ]
                );

                $setup->getConnection()->addColumn(
                $setup->getTable('testimonials'),
                    'company',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, // Or any other type
                        'nullable' => true, // Or false
                        'comment' => 'Company',
                        'after' => 'website'
                    ]
                );

                $setup->getConnection()->addColumn(
                $setup->getTable('testimonials'),
                    'address',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, // Or any other type
                        'nullable' => true, // Or false
                        'comment' => 'Address',
                        'after' => 'company'
                    ]
                );

                $setup->getConnection()->addColumn(
                $setup->getTable('testimonials'),
                    'testimonial',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, // Or any other type
                        'nullable' => true, // Or false
                        'comment' => 'testimonials',
                        'after' => 'address'
                    ]
                );
                
            }   
        }

        if (version_compare($context->getVersion(), '1.0.2') < 0) {
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                $setup->getConnection()->dropColumn($setup->getTable('testimonials'), 'content');
            }
        }
 
        $setup->endSetup();
    }
}