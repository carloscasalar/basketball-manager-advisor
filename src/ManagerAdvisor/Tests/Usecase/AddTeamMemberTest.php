<?php

    declare(strict_types=1);
    namespace ManagerAdvisor\Tests\usecase;

    use ManagerAdvisor\Domain\InvalidScoreException;
    use PHPUnit\Framework\TestCase;

    use ManagerAdvisor\Domain\Role;
    use Mockery;

    use ManagerAdvisor\Usecase\AddTeamMember;
    use ManagerAdvisor\Domain\TeamMember;
    use ManagerAdvisor\Domain\TeamMemberRepositoryInterface;
    use ManagerAdvisor\Domain\DuplicateUniformNameException;

    class AddTeamMemberTest extends TestCase {
        
        const UNIFORM_NUMBER = 7;
        const SCORE = 50;
        const PLAYER_NAME = 'Player Name';
        const ROLE_CODE = 'Role code';
        const ROLE_DESCRIPTION = 'Role description';

        /**
         * @var TeamMemberRepositoryInterface
         */
        private $teamMemberRepository;
        private $addTeamMember;

        protected function setUp() {
            $this->teamMemberRepository = Mockery::mock(TeamMemberRepositoryInterface::class);
            $this->addTeamMember = new AddTeamMember($this->teamMemberRepository);
        }

        /**
         * @test
         */
        public function should_save_new_team_member() {
            $teamMember = $this->getPlayer(self::UNIFORM_NUMBER, self::SCORE);
            $this->teamMemberRepository->expects()->findByUniformNumber(self::UNIFORM_NUMBER)->andReturns(null);
            $this->teamMemberRepository->expects()->create($teamMember);
            $this->addTeamMember->execute($teamMember);
        }

        /**
         * @test
         */
        public function uniform_number_should_be_unique() {
            $existingPlayer = $this->getPlayer(self::UNIFORM_NUMBER, self::SCORE);
            $this->teamMemberRepository->expects()->findByUniformNumber(self::UNIFORM_NUMBER)->andReturns($existingPlayer);

            $this->expectException(DuplicateUniformNameException::class);
            $newPlayer = $this->getPlayer(self::UNIFORM_NUMBER, self::SCORE);
            $this->addTeamMember->execute($newPlayer);
        }

        /**
         * @test
         */
        public function max_score_should_be_100(){
            $player = $this->getPlayer(self::UNIFORM_NUMBER, 101);
            $this->expectException(InvalidScoreException::class);
            $this->addTeamMember->execute($player);
        }

        /**
         * @test
         */
        public function min_score_should_be_0(){
            $player = $this->getPlayer(self::UNIFORM_NUMBER, -1);
            $this->expectException(InvalidScoreException::class);
            $this->addTeamMember->execute($player);
        }

        public function tearDown() {
            parent::tearDown();
            Mockery::close();
        }

        private function getPlayer(int $uniformNumber, int $score) {
            return new TeamMember(
                $uniformNumber,
                self::PLAYER_NAME,
                new Role(self::ROLE_CODE, self::ROLE_DESCRIPTION),
                $score
                );
        }
    }