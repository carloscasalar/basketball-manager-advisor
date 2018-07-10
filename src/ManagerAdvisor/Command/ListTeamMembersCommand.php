<?php

    namespace ManagerAdvisor\Command;

    use ManagerAdvisor\Command\View\OrderAdapter;
    use ManagerAdvisor\Command\View\OrderOptions;
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
         * @var TeamMemberViewAdapter
         */
        private $teamMemberAdapter;

        /**
         * @var TeamMemberTableRowAdapter
         */
        private $teamMemberTableRowAdapter;

        /**
         * @var OrderAdapter
         */
        private $orderAdapter;

        public function __construct(Injector $injector) {
            parent::__construct();
            $this->listTeamMembers = new ListTeamMembers($injector->getTeamMemberRepository());
            $this->teamMemberAdapter = new TeamMemberViewAdapter();
            $this->teamMemberTableRowAdapter = new TeamMemberTableRowAdapter();
            $this->orderAdapter = new OrderAdapter();
        }

        protected function configure() {
            $this
                ->setName('listTeamMembers')
                ->setDescription('List all team members')
                ->setDefinition(
                    new InputDefinition(array(
                        new InputOption(
                            'order',
                            'o',
                            InputOption::VALUE_OPTIONAL,
                            sprintf(
                                'Order to list team members. Available orders are %s, %s, %s',
                                OrderOptions::ARBITRARY, OrderOptions::UNIFORM_NUMBER, OrderOptions::ROLE_AND_SCORE),
                            OrderOptions::DEFAULT_ORDER_LITERAL
                        ),
                        new InputOption(
                            'format',
                            'f',
                            InputOption::VALUE_OPTIONAL,
                            'Format of the list to show. Available formats are TABLE, JSON',
                            'TABLE')
                    ))
                )
                ->setHelp('List all team members. Default order is arbitrary. Default format is table.');
        }

        protected function execute(InputInterface $input, OutputInterface $output) {
            $order = $this->readOrder($input, $output);

            try {
                $teamMembers = array_map(
                    $this->teamMemberTableRowAdapter->toTableRowCallback(),
                    $this->listTeamMembers->execute($order)
                );

                $table = new Table($output);
                $table
                    ->setHeaders(array(
                        array(new TableCell('Team members', array('colspan' => 4))),
                        array('UniformNumber', 'Name', 'Ideal role', 'Coach score')
                    ))
                    ->setRows($teamMembers);
                $table->render();
            } catch (\Exception $exception) {
                $output->writeln('<error>Error while listing team member list: ' . $exception->getMessage() . '</error>');
            }

        }

        private function readOrder(InputInterface $input, OutputInterface $output) {
            $typedOrder = strtoupper($input->getOption('order'));
            $order = $this->orderAdapter->toTeamMemberOrder($typedOrder);
            if (is_null($order)) {
                $output->writeln(sprintf('<error>Unknown order option "%s", using "%s" option instead.</error>', $typedOrder, OrderOptions::DEFAULT_ORDER_LITERAL));
                $order = $this->orderAdapter->toTeamMemberOrder(OrderOptions::DEFAULT_ORDER_LITERAL);
            }
            return $order;
        }
    }