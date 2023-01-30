<?php

namespace App\Command;
// Source : https://symfony.com/doc/current/console.html

use App\Entity\Credential;
use App\Repository\CredentialRepository;
use App\Service\CredentialManager;
use PHPUnit\Util\Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:make:admin',
    description: 'Creates a new admin.'
)]
class MakeAdminCommand extends Command
{
    private CredentialManager $credManager;

    public function __construct(CredentialManager $credManager){
        parent::__construct();
        $this->credManager = $credManager;
    }

    protected function configure(){
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Email : ')
            ->addArgument('password', InputArgument::OPTIONAL, 'Password : ')
            ->setHelp('This command allows you to create a user...');
    }

    private function askQuestion(InputInterface $input, OutputInterface $output, string $argumentName, bool $isHidden = false){
        if($input->getArgument(strtolower($argumentName)) === null){
            $question = new Question($this->getDefinition()->getArgument(strtolower($argumentName))->getDescription());
            $question->setValidator(function($value){
                if(trim($value) === ''){
                    throw new Exception('Value can\'t be empty');
                }
                return $value;
            });

            if($isHidden){
                $question->setHidden(true);
                $question->setHiddenFallback(false);
            }

            $input->setArgument($argumentName, $this->getHelper('question')->ask($input,$output,$question));
        } else {
            return $this->getDefinition()->getArgument(strtolower($argumentName));
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // ... put here the code to create the user

        $output->writeln([
            'Admin Account Creator',
            '============',
            '',
        ]);

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable
        $this->askQuestion($input, $output, 'email');
        $this->askQuestion($input, $output, 'password', true);

        /*$user = new Credential();
        $user
            ->setEmail($input->getArgument('email'))
            ->setPassword(
                $this->passwordHasher(
                    $user,
                    $input->getArgument('password')
                )
            )
            ->setRoles(['ROLE_ADMIN']);

        $this->credentialRepository->save($user, true);*/
        $this->credManager->createAdmin($input->getArgument('email'), $input->getArgument('password'));

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}