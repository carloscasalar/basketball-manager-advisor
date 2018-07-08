<?php

    namespace ManagerAdvisor\Tests\Persistence\TeamMemberRepository;


    use ManagerAdvisor\Domain\TeamMemberRepositoryInterface;
    use ManagerAdvisor\Persistence\RoleRepository;
    use ManagerAdvisor\Persistence\TeamMemberEntity;
    use ManagerAdvisor\Persistence\TeamMemberRepository;
    use ManagerAdvisor\Tests\Persistence\StoreAbstractTest;

    class DeleteTest extends StoreAbstractTest{
        const UNIFORM_NUMBER = 77;
        const NAME = 'Gimli';
        const SCORE = 1;
        const IGNORE_CACHE = true;
        const ROLE = 'PG';

        const UNIFORM_NUMBER_DIFFERENT_FROM_EXISTING_ONE = 40;

        /**
         * @var TeamMemberRepositoryInterface
         */
        private $teamMemberRepository;

        protected function setUp() {
            parent::setUp();

            $gimli = new TeamMemberEntity(
                self::UNIFORM_NUMBER,
                self::NAME,
                self::ROLE,
                self::SCORE
            );

            $this->storeManager->init();
            $store = $this->storeManager->load();
            $store->addTeamMember($gimli);

            $this->storeManager->persist($store);

            $roleRepository = new RoleRepository($this->storeManager);
            $this->teamMemberRepository = new TeamMemberRepository($this->storeManager, $roleRepository);
        }

        /**
         * @test
         */
        public function should_delete_team_member(){
            $existsMemberBeforeDelete = !empty($this->storeManager
                ->load(true)
                ->getTeamMembers());

            $this->teamMemberRepository->deleteByUniformNumber(self::UNIFORM_NUMBER);

            $existsMemberAfterDelete = !empty($this->storeManager
                ->load(true)
                ->getTeamMembers());

            self::assertTrue($existsMemberBeforeDelete, "This test does not meet its preconditions");
            self::assertFalse($existsMemberAfterDelete, "Member should be deleted");
        }

        /**
         * @test
         */
        public function should_not_delete_team_members_with_other_uniform_number(){
            $existsMemberBeforeDelete = !empty($this->storeManager
                ->load(true)
                ->getTeamMembers());

            $this->teamMemberRepository->deleteByUniformNumber(self::UNIFORM_NUMBER_DIFFERENT_FROM_EXISTING_ONE);

            $existsMemberAfterDelete = !empty($this->storeManager
                ->load(true)
                ->getTeamMembers());

            self::assertTrue($existsMemberBeforeDelete, "This test does not meet its preconditions");
            self::assertTrue($existsMemberAfterDelete, "No Member should be deleted");
        }
    }