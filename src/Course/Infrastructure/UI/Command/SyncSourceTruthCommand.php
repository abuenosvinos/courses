<?php

namespace App\Course\Infrastructure\UI\Command;

use App\Course\Application\SyncData\SyncDataCommand;
use App\Course\Domain\Repository\SourceTruthRepository;
use App\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SyncSourceTruthCommand extends Command
{
    protected static $defaultName = 'app:sync-source-truth';

    private SourceTruthRepository $sourceTruthRepository;
    private CommandBus $commandBus;

    /**
     * @var SymfonyStyle
     */
    private $io;

    public function __construct(SourceTruthRepository $sourceTruthRepository, CommandBus $commandBus)
    {
        parent::__construct();

        $this->sourceTruthRepository = $sourceTruthRepository;
        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('path', InputArgument::OPTIONAL, 'Path to process')
            ->setDescription('Sync the source of truth with the database')
            ->setHelp($this->getCommandHelp())
        ;
    }

    /**
     * This optional method is the first one executed for a command after configure()
     * and is useful to initialize properties based on the input arguments and options.
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        // SymfonyStyle is an optional feature that Symfony provides so you can
        // apply a consistent look to the commands of your application.
        // See https://symfony.com/doc/current/console/style.html
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //$path = $this->params->get('path');

        $courses = $this->sourceTruthRepository->load();

        $this->commandBus->dispatch(new SyncDataCommand($courses));

        $this->io->success('Se ha realizado la sincronización');

        return Command::SUCCESS;
    }

    private function getCommandHelp(): string
    {
        return <<<'HELP'
The <info>%command.name%</info> sync the source of truth with the database
HELP;
    }
}
