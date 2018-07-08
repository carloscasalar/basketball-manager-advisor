<?php
    namespace ManagerAdvisor\Tests\Usecase;


    use ManagerAdvisor\Domain\Role;
    use ManagerAdvisor\Domain\TeamMember;
    use ManagerAdvisor\Usecase\DeleteTeamMember;
    use ManagerAdvisor\Domain\DoesNotExistsTeamMemberWithUniformNumberException;
    use ManagerAdvisor\Domain\TeamMemberRepositoryInterface;
    use Mockery;
    use PHPUnit\Framework\TestCase;

    class DeleteTeamMemberTest extends TestCase {
        const UNIFORM_NUMBER = 7;
        const SCORE = 50;
        const PLAYER_NAME = 'Player Name';
        const ROLE_CODE = 'C';
        const ROLE_DESCRIPTION = 'Center';

        /**
         * @var TeamMemberRepositoryInterface
         */
        private $teamMemberRepository;
        /**
         * @var DeleteTeamMember
         */
        private $deleteTeamMember;

        protected function setUp() {
            $this->teamMemberRepository = Mockery::mock(TeamMemberRepositoryInterface::class);
            $this->deleteTeamMember = new DeleteTeamMember($this->teamMemberRepository);
        }

        /**
         * @test
         */
        public function should_thrown_if_team_member_does_not_exists () {
            $this->teamMemberRepository->expects()->findByUniformNumber(self::UNIFORM_NUMBER)->andReturns(null);
            $this->expectException(DoesNotExistsTeamMemberWithUniformNumberException::class);

            $this->deleteTeamMember->execute(self::UNIFORM_NUMBER);

            self::assertTrue(true,'This assertion prevents risky warning');
        }

        /**
         * @test
         */
        public function should_delete_team_member_if_exists() {
            $existingPlayer = $this->getPlayer(self::UNIFORM_NUMBER, self::SCORE);
            $this->teamMemberRepository->expects()->findByUniformNumber(self::UNIFORM_NUMBER)->andReturns($existingPlayer);
            $this->teamMemberRepository->expects()->deleteByUniformNumber(self::UNIFORM_NUMBER);

            $this->deleteTeamMember->execute(self::UNIFORM_NUMBER);
            self::assertTrue(true,'This assertion prevents risky warning');
        }

        private function getPlayer(int $uniformNumber, int $score) {
            return new TeamMember(
                $uniformNumber,
                self::PLAYER_NAME,
                new Role(self::ROLE_CODE, self::ROLE_DESCRIPTION),
                $score
            );
        }

        public function tearDown() {
            parent::tearDown();
            Mockery::close();
        }
    }