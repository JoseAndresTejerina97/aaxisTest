<?php
namespace App\Infrastructure\Command;

use App\Application\CreateUser;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'aaxis:create-user')]
class CreateUserCommand extends Command
{
    private $createUserApplication;

    public function __construct(CreateUser $createUserApplication)
    {
        $this->createUserApplication = $createUserApplication;
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
       
        try {
            $username="aaxis";
            $password="aaxis_test";
            $result=$this->createUserApplication->execute($username,$password);
            if ($result === true) {
                return Command::SUCCESS;
            } else {
                return Command::FAILURE;
            }
        } catch (Exception $exception) {
            return Command::FAILURE;
        }

    }
}
