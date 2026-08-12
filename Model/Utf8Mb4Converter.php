<?php
/**
 * Copyright (c) 2026 BluePrint3D Ltd. All rights reserved.
 */
namespace BluePrint3D\AllowUtf8mb4\Model;

use Magento\Framework\App\ResourceConnection;

class Utf8Mb4Converter
{
    private const TARGET_CHARSET = 'utf8mb4';
    private const TARGET_COLLATION = 'utf8mb4_unicode_ci';

    /**
     * Magento's declarative schema regenerates column definitions using a global
     * default charset on every setup:upgrade, ignoring any table-level charset
     * override in db_schema.xml (there is no column-level charset attribute in
     * the schema XSD). So these columns need to be re-converted after every
     * upgrade, not just once at install.
     */
    private const TABLES = [
        'catalog_product_entity_varchar',
        'catalog_product_entity_text',
        'cms_block',
        'cms_page',
    ];

    private ResourceConnection $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Convert any target table whose columns have drifted off utf8mb4 back to it.
     * Tables already fully on utf8mb4/utf8mb4_unicode_ci are left untouched.
     *
     * @return string[] Names of tables that actually needed (and got) converting.
     */
    public function convert(): array
    {
        $connection = $this->resourceConnection->getConnection();
        $converted = [];

        foreach (self::TABLES as $table) {
            $tableName = $this->resourceConnection->getTableName($table);
            if (!$connection->isTableExists($tableName)) {
                continue;
            }

            if ($this->hasDrifted($connection, $tableName)) {
                $connection->query(
                    "ALTER TABLE `{$tableName}` CONVERT TO CHARACTER SET "
                    . self::TARGET_CHARSET . " COLLATE " . self::TARGET_COLLATION
                );
                $converted[] = $tableName;
            }
        }

        return $converted;
    }

    /**
     * Whether any character column on this table is not on the target charset/collation.
     */
    private function hasDrifted($connection, string $tableName): bool
    {
        $sql = 'SELECT COUNT(*) FROM information_schema.COLUMNS '
            . 'WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? '
            . 'AND CHARACTER_SET_NAME IS NOT NULL '
            . 'AND (CHARACTER_SET_NAME != ? OR COLLATION_NAME != ?)';

        $driftedColumnCount = (int)$connection->fetchOne(
            $sql,
            [$tableName, self::TARGET_CHARSET, self::TARGET_COLLATION]
        );

        return $driftedColumnCount > 0;
    }
}
