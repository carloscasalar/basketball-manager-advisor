<?php
    namespace ManagerAdvisor\Command\Printer;

    use ManagerAdvisor\Command\View\TeamMemberTableRowAdapter;
    use Symfony\Component\Console\Helper\Table;
    use Symfony\Component\Console\Helper\TableCell;
    use Symfony\Component\Console\Output\OutputInterface;

    class TeamMemberListTablePrinter implements PrinterInterface {

        /**
         * @var TeamMemberTableRowAdapter
         */
        private $teamMemberTableRowAdapter;

        /**
         * @var OutputInterface
         */
        private $output;

        public function __construct(OutputInterface $output) {
            $this->output = $output;
           $this->teamMemberTableRowAdapter = new TeamMemberTableRowAdapter();
        }

        public function render(array $teamMembers): void {
           $teamMemberRows = array_map(
               $this->teamMemberTableRowAdapter->toTableRowCallback(),
               $teamMembers
           );
            $table = new Table($this->output);
            $table
                ->setHeaders(array(
                    array(new TableCell('Team members', array('colspan' => 4))),
                    array('UniformNumber', 'Name', 'Ideal role', 'Coach score')
                ))
                ->setRows($teamMemberRows);
            $table->render();
        }
    }