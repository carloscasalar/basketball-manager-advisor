<?php

    namespace ManagerAdvisor\Command;

    use ManagerAdvisor\Command\View\TeamMemberTableRowAdapter;
    use ManagerAdvisor\Command\View\TeamMemberViewAdapter;
    use ManagerAdvisor\Domain\TeamMemberOrder;
    use ManagerAdvisor\Injector\Injector;
    use ManagerAdvisor\Tests\Usecase\ListTeamMembersTest;
    use ManagerAdvisor\Usecase\ListTeamMembers;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Helper\Table;
    use Symfony\Component\Console\Helper\TableCell;
    use Symfony\Component\Console\Input\InputDefinition;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Output\OutputInterface;

    class ListTeamMembersCommand extends Command {

        /**
         * @var ListTeamMembersTest
         */
        private $listTeamMembers;

        /**
         * @var TeamMemberTableRowAdapter
         */
        private $teamMemberTableRowAdapter;

        public function __construct(Injector $injector) {
            parent::__construct();
            $this->listTeamMembers = new ListTeamMembers($injector->getTeamMemberRepository());

            $this->teamMemberTableRowAdapter = new TeamMemberTableRowAdapter();
        }

        protected function configure() {
            $this
                ->setName('listTeamMembers')
                ->setDescription('List all team members')
                ->setHelp('List all team members. Default order is arbitrary. Default format is table.');
        }

        protected function execute(InputInterface $input, OutputInterface $output) {
            try {
                $teamMembers = array_map(
                    $this->teamMemberTableRowAdapter->toTableRowCallback(),
                    $this->listTeamMembers->execute(TeamMemberOrder::arbitrary())
                );

                $table = new Table($output);
                $table
                    ->setHeaders(array(
                        array(new TableCell('Team members', array('colspan' => 4))),
                        array('UniformNumber', 'Name', 'Ideal role', 'Coach score')
                    ))
                    ->setRows($teamMembers)
                ;
                $table->render();
            } catch (\Exception $exception) {
                $output->writeln('<error>Error while listing team member list: ' . $exception->getMessage() . '</error>');
            }

        }
    }