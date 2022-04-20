<?php


namespace App\Commands;

use App\Services\Authentication\Authentication;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;

class CreateAdminUserCommand extends Command
{

    private $authentication;

    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('user:create')
            ->setDescription('create admin user, email password')
            ->setHelp('create admin user, email password')
            ->addArgument('email', InputArgument::REQUIRED, 'user email')
            ->addArgument('password', InputArgument::REQUIRED, 'user password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $this->authentication->updateOrCreateUser([
            'email' => $email,
            'password' => $password
        ]);
        return Command::SUCCESS;
    }

}