<?php

namespace App\Course\Infrastructure\UI\Command;

use App\Course\Application\GetTokenUser\GetTokenUserQuery;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetTokenUserCommand extends Command
{
    protected static $defaultName = 'app:get-token-user';

    private QueryBus $queryBus;

    /**
     * @var SymfonyStyle
     */
    private $io;

    public function __construct(QueryBus $queryBus)
    {
        parent::__construct();

        $this->queryBus = $queryBus;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED, 'Username of the User')
            ->setDescription('Get the token of a user to access the system')
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
        $username = $input->getArgument('username');

        $token = $this->queryBus->ask(new GetTokenUserQuery($username));

        if ($token) {
            $this->io->success('Token: ' . $token);

        } else {
            $this->io->success('No se ha podido obtener un token para el usuario indicado');
        }

        return Command::SUCCESS;
    }

    private function getCommandHelp(): string
    {
        return <<<'HELP'
The <info>%command.name%</info> get the token of a user to access the system
HELP;
    }
}
