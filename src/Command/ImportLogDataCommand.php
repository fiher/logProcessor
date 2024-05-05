<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\LogImporterInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'log:import-data',
    description: 'Imports logs from public/logs folder',
    aliases: ['log:import-data'],
    hidden: false
)]
class ImportLogDataCommand extends Command
{
    public function __construct(private LogImporterInterface $importer)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->importer->importLocalLogFile();

        $output->writeln('Logs saved in the background.');

        \shell_exec('php bin/console messenger:consume async --limit=20 -v');

        return Command::SUCCESS;
    }
}