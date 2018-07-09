<?php

    namespace ManagerAdvisor\Tests\Persistence\TeamMemberRepository;


    use ManagerAdvisor\Domain\Role;
    use ManagerAdvisor\Domain\TeamMember;
    use ManagerAdvisor\Domain\TeamMemberOrder;
    use ManagerAdvisor\Domain\TeamMemberRepositoryInterface;
    use ManagerAdvisor\Persistence\RoleEntity;
    use ManagerAdvisor\Persistence\RoleRepository;
    use ManagerAdvisor\Persistence\Store;
    use ManagerAdvisor\Persistence\TeamMemberEntity;
    use ManagerAdvisor\Persistence\TeamMemberRepository;
    use ManagerAdvisor\Tests\Persistence\StoreAbstractTest;

    class FindAllTest extends StoreAbstractTest {
        const UNIFORM_NUMBER_1 = 1;
        const UNIFORM_NUMBER_2 = 2;
        const UNIFORM_NUMBER_3 = 3;
        const SCORE_100 = 100;
        const SCORE_50 = 50;
        const NO_STRATEGIES = [];
        const CENTER_ROLE_CODE = 'C';
        const CENTER_ROLE_DESCRIPTION = 'Center';
        const SHOOTING_GUARD_CODE = 'SG';
        const SHOOTING_GUARD_ROLE_DESCRIPTION = 'Shooting Guard';

        /**
         * @var TeamMemberRepositoryInterface
         */
        private $teamMemberRepository;

        private $member3_SG_50;
        private $member2_C_100;
        private $member1_C_50;

        protected function setUp() {
            parent::setUp();

            $roles = [
                $this->getCenterRoleEntity(),
                $this->getShootingGuardRoleEntity(),
            ];

            $storedPlayers = [
                $this->getTeamMemberEntity(self::UNIFORM_NUMBER_3, self::SHOOTING_GUARD_CODE, self::SCORE_50),
                $this->getTeamMemberEntity(self::UNIFORM_NUMBER_2, self::CENTER_ROLE_CODE, self::SCORE_100),
                $this->getTeamMemberEntity(self::UNIFORM_NUMBER_1, self::CENTER_ROLE_CODE, self::SCORE_50)
            ];

            $store = new Store($roles, self::NO_STRATEGIES, $storedPlayers);

            $this->storeManager->persist($store);

            $roleRepository = new RoleRepository($this->storeManager);
            $this->teamMemberRepository = new TeamMemberRepository($this->storeManager, $roleRepository);

            $this->member1_C_50 = $this->getTeamMember(self::UNIFORM_NUMBER_1, $this->getCenterRole(), self::SCORE_50);
            $this->member2_C_100 = $this->getTeamMember(self::UNIFORM_NUMBER_2, $this->getCenterRole(), self::SCORE_100);
            $this->member3_SG_50 = $this->getTeamMember(self::UNIFORM_NUMBER_3, $this->getShootingGuardRole(), self::SCORE_50);
        }

        /**
         * @test
         */
        public function arbitrary_order_should_return_member_in_persisted_order() {
            $normalized = $this->teamMemberRepository->findAll(TeamMemberOrder::arbitrary());

            $expectedPlayerList = [
                $this->member3_SG_50,
                $this->member2_C_100,
                $this->member1_C_50
            ];

            self::assertEquals(
                $this->getUniformRoleAndScore($expectedPlayerList),
                $this->getUniformRoleAndScore($normalized),
                'Should return all team members in the same order they are stored');
        }

        /**
         * @test
         */
        public function uniform_number_order_should_return_member_list_ordered_asc_by_uniform_number() {
            $normalized = $this->teamMemberRepository->findAll(TeamMemberOrder::byUniformNumber());

            $expectedPlayerList = [
                $this->member1_C_50,
                $this->member2_C_100,
                $this->member3_SG_50
            ];

            self::assertEquals(
                $this->getUniformRoleAndScore($expectedPlayerList),
                $this->getUniformRoleAndScore($normalized),
                'Should return members ordered by uniform number');
        }

        /**
         * @test
         */
        public function role_and_score_order_should_return_member_list_ordered_asc_by_role_and_desc_by_score() {
            $normalized = $this->teamMemberRepository->findAll(TeamMemberOrder::byRoleAndScore());

            $expectedPlayerList = [
                $this->member2_C_100,
                $this->member1_C_50,
                $this->member3_SG_50
            ];

            self::assertEquals(
                $this->getUniformRoleAndScore($expectedPlayerList),
                $this->getUniformRoleAndScore($normalized),
                'Should return members ordered by uniform number');
        }

        private function getUniformRoleAndScore(array $members): array {
            return array_map(
                function (TeamMember $teamMember): string {
                    return $teamMember->getUniformNumber()
                        . ' / '
                        . $teamMember->getIdealRole()->getDescription()
                        . ' / '
                        . $teamMember->getCoachScore();
                },
                $members
            );
        }

        private function getTeamMember(int $uniformNumber, Role $idealRole, int $coachScore) {
            return new TeamMember(
                $uniformNumber,
                'Team with uniform number ' . $uniformNumber,
                $idealRole,
                $coachScore
            );
        }

        private function getTeamMemberEntity(int $uniformNumber, string $idealRoleCode, int $coachScore): TeamMemberEntity {
            return new TeamMemberEntity(
                $uniformNumber,
                'Team with uniform number ' . $uniformNumber,
                $idealRoleCode,
                $coachScore
            );
        }

        private function getCenterRole(): Role {
            return new Role(self::CENTER_ROLE_CODE, self::CENTER_ROLE_DESCRIPTION);
        }

        private function getShootingGuardRole(): Role {
            return new Role(self::SHOOTING_GUARD_CODE, self::SHOOTING_GUARD_ROLE_DESCRIPTION);
        }

        private function getCenterRoleEntity(): RoleEntity {
            return new RoleEntity(self::CENTER_ROLE_CODE, self::CENTER_ROLE_DESCRIPTION);
        }

        private function getShootingGuardRoleEntity(): RoleEntity {
            return new RoleEntity(self::SHOOTING_GUARD_CODE, self::SHOOTING_GUARD_ROLE_DESCRIPTION);
        }
    }