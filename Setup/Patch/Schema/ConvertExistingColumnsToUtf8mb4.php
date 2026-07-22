<?php
/**
 * Copyright (c) 2026 BluePrint3D Ltd. All rights reserved.
 */
namespace BluePrint3D\AllowUtf8mb4\Setup\Patch\Schema;

use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class ConvertExistingColumnsToUtf8mb4 implements SchemaPatchInterface
{
    private $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        $connection = $this->moduleDataSetup->getConnection();

        // The tables that need forcing
        $tables = [
            'catalog_product_entity_varchar',
            'catalog_product_entity_text',
            'cms_block',
            'cms_page'
        ];

        foreach ($tables as $table) {
            // getTable() ensures we support customers with DB prefixes (e.g., mg_cms_block)
            $tableName = $this->moduleDataSetup->getTable($table);

            if ($connection->isTableExists($tableName)) {
                $sql = "ALTER TABLE `{$tableName}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
                $connection->query($sql);
            }
        }

        $this->moduleDataSetup->endSetup();
        return $this;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}