<?php
/**
 * Copyright (c) 2026 BluePrint3D Ltd. All rights reserved.
 */
namespace BluePrint3D\AllowUtf8mb4\Setup\Patch\Schema;

use BluePrint3D\AllowUtf8mb4\Model\Utf8Mb4Converter;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Runs once on install. Schema patches never re-run on later setup:upgrade calls,
 * so this alone isn't enough to keep the columns on utf8mb4 - see
 * Plugin\Setup\ReassertUtf8Mb4Plugin, which re-applies the same conversion after
 * every setup:upgrade.
 */
class ConvertExistingColumnsToUtf8mb4 implements SchemaPatchInterface
{
    private $moduleDataSetup;
    private $converter;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup, Utf8Mb4Converter $converter)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->converter = $converter;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        $this->converter->convert();
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
