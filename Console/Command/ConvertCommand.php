<?php
/**
 * Copyright (c) 2026 BluePrint3D Ltd. All rights reserved.
 */
namespace BluePrint3D\AllowUtf8mb4\Console\Command;

use BluePrint3D\AllowUtf8mb4\Model\Utf8Mb4Converter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertCommand extends Command
{
    private Utf8Mb4Converter $converter;

    public function __construct(Utf8Mb4Converter $converter)
    {
        $this->converter = $converter;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('blueprint3d:utf8mb4:convert');
        $this->setDescription(
            'Re-applies utf8mb4 charset/collation to the columns managed by BluePrint3D_AllowUtf8mb4. '
            . 'Magento\'s declarative schema silently reverts these columns to the legacy charset on every '
            . 'setup:upgrade, so run this again after each deploy that runs setup:upgrade.'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $converted = $this->converter->convert();

        if (empty($converted)) {
            $output->writeln('<comment>All target tables are already on utf8mb4 - nothing to do.</comment>');
            return Command::SUCCESS;
        }

        foreach ($converted as $table) {
            $output->writeln("<info>Converted {$table} to utf8mb4.</info>");
        }

        return Command::SUCCESS;
    }
}
