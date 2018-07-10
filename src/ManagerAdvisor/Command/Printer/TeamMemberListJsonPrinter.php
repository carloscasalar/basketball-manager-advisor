<?php
    namespace ManagerAdvisor\Command\Printer;

    use ManagerAdvisor\Command\View\TeamMemberViewAdapter;
    use ManagerAdvisor\Domain\TeamMember;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Serializer\Encoder\JsonEncoder;
    use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
    use Symfony\Component\Serializer\Serializer;

    class TeamMemberListJsonPrinter implements PrinterInterface {

        /**
         * @var TeamMemberViewAdapter
         */
        private $teamMemberViewAdapter;

        /**
         * @var Serializer
         */
        private $serializer;

        /**
         * @var OutputInterface
         */
        private $output;

        public function __construct(OutputInterface $output) {
            $this->output = $output;
            $this->teamMemberViewAdapter = new TeamMemberViewAdapter();
            $this->serializer = $this->getSerializer();
        }

        /**
         * @param TeamMember[] $teamMembers
         */
        public function render(array $teamMembers): void {
            $teamMembersViewRows = array_map(
                $this->teamMemberViewAdapter->toTeamMemberViewCallback(),
                $teamMembers
            );

            $jsonList = $this->serializer->serialize($teamMembersViewRows, 'json');
            $this->output->writeln($jsonList);
        }

        private function getSerializer(): Serializer {
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());

            return new Serializer($normalizers, $encoders);
        }
    }