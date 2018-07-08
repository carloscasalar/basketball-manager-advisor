<?php

    namespace ManagerAdvisor\Tests\Persistence\TeamMemberRepository;

    use ManagerAdvisor\Domain\Role;
    use ManagerAdvisor\Domain\TeamMember;
    use ManagerAdvisor\Domain\TeamMemberRepositoryInterface;
    use ManagerAdvisor\Persistence\RoleRepository;
    use ManagerAdvisor\Persistence\TeamMemberRepository;
    use ManagerAdvisor\Tests\Persistence\StoreAbstractTest;

    class CreateTest extends StoreAbstractTest {
        const UNIFORM_NUMBER = 77;
        const NAME = 'Gimli';
        const SCORE = 1;
        const IGNORE_CACHE = true;

        /**
         * @var TeamMemberRepositoryInterface
         */
        private $teamMemberRepository;

        protected function setUp() {
            parent::setUp();

            $this->storeManager->init();

            $roleRepository = new RoleRepository($this->storeManager);
            $this->teamMemberRepository = new TeamMemberRepository($this->storeManager, $roleRepository);
        }

        /**
         * @test
         */
        public function should_persist_a_new_team_member_in_store() {
            $pointGuardRole = new Role("PG", "Point Guard");
            $teamMember = new TeamMember(
                self::UNIFORM_NUMBER,
                self::NAME,
                $pointGuardRole,
                self::SCORE
            );

            $this->teamMemberRepository->create($teamMember);

            $store = $this->storeManager->load(self::IGNORE_CACHE);

            self::assertNotEmpty($store->getTeamMembers(), "Should store team member");
            $memberEntity = $store->getTeamMembers()[0];
            self::assertEquals(self::UNIFORM_NUMBER, $memberEntity->getUniformNumber());
            self::assertEquals(self::NAME, $memberEntity->getName());
            self::assertEquals($pointGuardRole->getCode(), $memberEntity->getRole());
            self::assertEquals(self::SCORE, $memberEntity->getCoachScore());
        }

        protected function tearDown() {
            parent::tearDown();
        }

    }