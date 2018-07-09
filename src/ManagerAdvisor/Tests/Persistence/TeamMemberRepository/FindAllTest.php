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
        const UNIFORM_NUMBER_ONE = 1;
        const UNIFORM_NUMBER_TWO = 2;
        const PLAYER_ONE_NAME = "Player one";
        const PLAYER_TWO_NAME = "Player two";
        const SCORE_100 = 100;
        const SCORE_50 = 50;
        const NO_STRATEGIES = [];
        const CENTER_ROLE_CODE = 'C';
        const CENTER_ROLE_DESCRIPTION = 'Center';

        /**
         * @var TeamMemberRepositoryInterface
         */
        private $teamMemberRepository;

        protected function setUp() {
            parent::setUp();

            $roles = [new RoleEntity("C", "Center")];

            $players = [
                $this->getTeamMemberEntityB(),
                $this->getTeamMemberEntityA()
            ];

            $store = new Store($roles, self::NO_STRATEGIES, $players);

            $this->storeManager->persist($store);

            $roleRepository = new RoleRepository($this->storeManager);
            $this->teamMemberRepository = new TeamMemberRepository($this->storeManager, $roleRepository);
        }

        /**
         * @test
         */
        public function should_return_team_member_list_normalized_by_uniform_id() {
            $normalized = $this->teamMemberRepository->findAll(TeamMemberOrder::arbitrary());

            $expectedPlayerList = [
                $this->getTeamMemberB(),
                $this->getTeamMemberA()
            ];

            self::assertEquals($expectedPlayerList, $normalized, 'Should return player all team members in the same order they are stored');
        }

        private function getTeamMemberA(): TeamMember {
            return new TeamMember(
                self::UNIFORM_NUMBER_ONE,
                self::PLAYER_ONE_NAME,
                $this->getCenterRole(),
                self::SCORE_100
            );
        }

        private function getTeamMemberB(): TeamMember {
            return new TeamMember(
                self::UNIFORM_NUMBER_TWO,
                self::PLAYER_TWO_NAME,
                $this->getCenterRole(),
                self::SCORE_50
            );
        }

        private function getTeamMemberEntityA(): TeamMemberEntity {
            return new TeamMemberEntity(
                self::UNIFORM_NUMBER_ONE,
                self::PLAYER_ONE_NAME,
                self::CENTER_ROLE_CODE,
                self::SCORE_100
            );
        }

        private function getTeamMemberEntityB(): TeamMemberEntity {
            return new TeamMemberEntity(
                self::UNIFORM_NUMBER_TWO,
                self::PLAYER_TWO_NAME,
                self::CENTER_ROLE_CODE,
                self::SCORE_50
            );
        }

        private function getCenterRole(): Role {
            return new Role(self::CENTER_ROLE_CODE, self::CENTER_ROLE_DESCRIPTION);
        }
    }