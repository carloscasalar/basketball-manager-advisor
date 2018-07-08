<?php
    namespace ManagerAdvisor\Command;

    use ManagerAdvisor\Command\Questions\UniformNumberQuestion;
    use ManagerAdvisor\Injector\Injector;
    use ManagerAdvisor\Usecase\DeleteTeamMember;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    class DeleteTeamMemberCommand extends Command {
        const ENTER_UNIFORM_NUMBER_TO_DELETE = 'Enter de uniform number of the team member to delete';

        /**
         * @var UniformNumberQuestion
         */
        private $uniformNumberQuestion;

        /**
         * @var DeleteTeamMember
         */
        private $deleteTeamMember;

        public function __construct(Injector $injector) {
            parent::__construct();
            $this->uniformNumberQuestion = new UniformNumberQuestion(self::ENTER_UNIFORM_NUMBER_TO_DELETE);

            $this->deleteTeamMember = $injector->getDeleteTeamMember();
        }

        protected function configure() {
            $this
                ->setName('deleteTeamMember')
                ->setDescription('Delete an existing team member')
                ->setHelp('This command deletes a team member');
        }

        protected function execute(InputInterface $input, OutputInterface $output) {
            $helper = $this->getHelper('question');

            $uniformNumber = $this->uniformNumberQuestion->ask($input,$output,$helper);

            try{
                $this->deleteTeamMember->execute($uniformNumber);
                $output->writeln('<bg=green;options=bold>Team member deleted</>');
            }catch (\Exception $exception){
                $output->writeln('<error>Error deleting team member: '.$exception->getMessage().'</error>');
            }

        }
    }