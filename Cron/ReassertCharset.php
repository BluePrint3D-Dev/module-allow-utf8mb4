<?php
/**
 * Copyright (c) 2026 BluePrint3D Ltd. All rights reserved.
 */
namespace BluePrint3D\AllowUtf8mb4\Cron;

use BluePrint3D\AllowUtf8mb4\Model\Utf8Mb4Converter;
use Psr\Log\LoggerInterface;

/**
 * Safety net: a plugin on Magento\Setup\Console\Command\UpgradeCommand does not
 * actually fire (Magento's setup:* commands bootstrap outside the normal
 * interception/DI chain), so there is no reliable hook to catch declarative
 * schema reverting these columns immediately after setup:upgrade. This cron job
 * re-applies the conversion periodically instead, so drift self-heals even if a
 * deploy forgets to run `bin/magento blueprint3d:utf8mb4:convert` manually.
 */
class ReassertCharset
{
    private Utf8Mb4Converter $converter;
    private LoggerInterface $logger;

    public function __construct(Utf8Mb4Converter $converter, LoggerInterface $logger)
    {
        $this->converter = $converter;
        $this->logger = $logger;
    }

    public function execute(): void
    {
        $converted = $this->converter->convert();
        if (!empty($converted)) {
            $this->logger->info(
                'BluePrint3D_AllowUtf8mb4: re-applied utf8mb4 charset to ' . implode(', ', $converted)
            );
        }
    }
}
