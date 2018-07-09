<?php
    namespace ManagerAdvisor\Tests\Usecase;

    use ManagerAdvisor\Domain\Role;
    use ManagerAdvisor\Domain\TeamMember;
    use ManagerAdvisor\Domain\TeamMemberOrder;
    use ManagerAdvisor\Domain\TeamMemberRepositoryInterface;
    use ManagerAdvisor\Usecase\ListTeamMembers;
    use Mockery;
    use PHPUnit\Framework\TestCase;

    class ListTeamMembersTest extends TestCase {

        const UNIFORM_NUMBER = 7;
        const PLAYER_NAME = 'Player Name';
        const ROLE_CODE = 'C';
        const ROLE_DESCRIPTION = 'Center';
        const SCORE = 50;

        /**
         * @var TeamMemberRepositoryInterface
         */
        private $teamMemberRepository;

        /**
         * @var ListTeamMembers
         */
        private $listTeamMembers;

        /**
         * @var TeamMember[]
         */
        private $teamMembers;

        protected function setUp() {
            $this->teamMemberRepository = Mockery::mock(TeamMemberRepositoryInterface::class);
            $this->listTeamMembers = new ListTeamMembers($this->teamMemberRepository);
            $this->teamMembers = [
                $this->getTeamMember(),
                $this->getTeamMember(),
                $this->getTeamMember()
            ];
        }

        public function tearDown() {
            parent::tearDown();
            Mockery::close();
        }

        /**
         * @test
         */
        public function with_uniform_number_order_criteria_should_query_member_list_ordered_by_uniform_number(){
            $order = TeamMemberOrder::byUniformNumber();
            $this->teamMemberRepository->expects()->findAll($order)->andReturns($this->teamMembers);

            $memberList = $this->listTeamMembers->execute($order);

            self::assertEquals($memberList, $this->teamMembers, 'Should return team member list from repository');
        }

        /**
         * @test
         */
        public function with_role_and_score_order_criteria_should_query_member_list_ordered_by_role_and_score(){
            $order = TeamMemberOrder::byRoleAndScore();
            $this->teamMemberRepository->expects()->findAll($order)->andReturns($this->teamMembers);

            $memberList = $this->listTeamMembers->execute($order);

            self::assertEquals($memberList, $this->teamMembers, 'Should return team member list from repository');
        }

        private function getTeamMember(){
            $idealRole = new Role(self::ROLE_CODE, self::ROLE_DESCRIPTION);
            return new TeamMember(
                self::UNIFORM_NUMBER,
                self::PLAYER_NAME,
                $idealRole,
                self::SCORE
            );
        }

    }