<?php
    namespace ManagerAdvisor\Tests\Persistence\TeamMemberRepository;

    use ManagerAdvisor\Domain\Role;
    use ManagerAdvisor\Domain\TeamMember;
    use ManagerAdvisor\Persistence\RoleEntity;
    use ManagerAdvisor\Persistence\RoleRepository;
    use ManagerAdvisor\Persistence\Store;
    use ManagerAdvisor\Persistence\TeamMemberEntity;
    use ManagerAdvisor\Persistence\TeamMemberRepository;
    use ManagerAdvisor\Tests\Persistence\StoreAbstractTest;

    class FindByUniformNumberTest extends StoreAbstractTest {
        const NUMBER_ONE = 1;
        const PLAYER_A_NAME = 'Player A';
        const PLAYER_A_ROLE = 'A';
        const PLAYER_A_SCORE = 25;

        const NUMBER_TWO = 2;
        const PLAYER_B_NAME = 'Player B';
        const PLAYER_B_ROLE = 'B';
        const PLAYER_B_SCORE = 75;
        const NO_STRATEGIES = [];

        const ROLE_A = 'A';
        const DESCRIPTION_ROLE_A = 'Role A';
        const ROLE_B = 'B';
        const DESCRIPTION_ROLE_B = 'Role B';

        const NONEXISTENT_UNIFORM_NUMBER = 99;

        /**
         * @var TeamMemberRepository
         */
        private $repository;

        protected function setUp() {
            parent::setUp();

            $memberWithNumberOne = new TeamMemberEntity(self::NUMBER_ONE, self::PLAYER_A_NAME, self::PLAYER_A_ROLE, self::PLAYER_A_SCORE);
            $memberWithNumberTwo = new TeamMemberEntity(self::NUMBER_TWO, self::PLAYER_B_NAME, self::PLAYER_B_ROLE, self::PLAYER_B_SCORE);

            $roles = [$this->getRoleEntityA(), $this->getRoleEntityB()];
            $strategies = self::NO_STRATEGIES;
            $store = new Store($roles, $strategies, [$memberWithNumberOne, $memberWithNumberTwo]);

            $this->storeManager->persist($store);

            $roleRepository = new RoleRepository();
            $this->repository = new TeamMemberRepository($this->storeManager, $roleRepository);
        }

        /**
         * @test
         */
        public function should_find_a_member_by_its_uniform_number(){
            $expectedMember = new TeamMember(self::NUMBER_TWO,self::PLAYER_B_NAME, $this->getRoleB(), self::PLAYER_B_SCORE);

            $foundMember = $this->repository->findByUniformNumber(self::NUMBER_TWO);

            self::assertEquals($expectedMember, $foundMember);
        }

        /**
         * @test
         */
        public function should_return_null_if_there_is_no_member_with_that_uniform_number(){
            $foundMember = $this->repository->findByUniformNumber(self::NONEXISTENT_UNIFORM_NUMBER);

            self::assertNull($foundMember);
        }

        protected function tearDown() {
            parent::tearDown();
        }

        private function getRoleEntityA(): RoleEntity {
            return new RoleEntity(self::ROLE_A, self::DESCRIPTION_ROLE_A);
        }

        private function getRoleEntityB(): RoleEntity {
            return new RoleEntity(self::ROLE_B, self::DESCRIPTION_ROLE_B);
        }

        private function getRoleB(): Role {
            return new Role(self::ROLE_B, self::DESCRIPTION_ROLE_B);
        }
    }