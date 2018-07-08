<?php
    declare(strict_types=1);

    namespace ManagerAdvisor\Injector;

    use ManagerAdvisor\Domain\RoleRepositoryInterface;
    use ManagerAdvisor\Domain\TeamMemberRepositoryInterface;
    use ManagerAdvisor\Persistence\RoleRepository;
    use ManagerAdvisor\Persistence\StoreManager;
    use ManagerAdvisor\Persistence\TeamMemberRepository;
    use ManagerAdvisor\Query\RoleQueries;
    use ManagerAdvisor\usecase\AddTeamMember;

    class Injector {
        const PRODUCTION = 'PROD';
        const TEST = 'TEST';

        /**
         * @var StoreManager
         */
        private $storeManager;

        /**
         * @var RoleRepositoryInterface
         */
        private $roleRepository;

        /**
         * @var TeamMemberRepositoryInterface
         */
        private $teamMemberRepository;

        /**
         * @var RoleQueries
         */
        private $roleQueries;

        /**
         * @var AddTeamMember
         */
        private $addTeamMember;

        public function __construct(string $environment = self::PRODUCTION) {
            $storeConfig = [
                self::PRODUCTION => 'resources/store',
                self::TEST => 'resources/test'
            ];

            $this->storeManager = new StoreManager($storeConfig[$environment]);
            $this->storeManager->init();

            $this->roleRepository = new RoleRepository($this->storeManager);
            $this->teamMemberRepository = new TeamMemberRepository($this->storeManager, $this->roleRepository);

            $this->roleQueries = new RoleQueries($this->roleRepository);

            $this->addTeamMember = new AddTeamMember($this->teamMemberRepository);
        }

        /**
         * @return StoreManager
         */
        public function getStoreManager(): StoreManager {
            return $this->storeManager;
        }

        /**
         * @return RoleRepositoryInterface
         */
        public function getRoleRepository(): RoleRepositoryInterface {
            return $this->roleRepository;
        }

        /**
         * @return TeamMemberRepositoryInterface
         */
        public function getTeamMemberRepository(): TeamMemberRepositoryInterface {
            return $this->teamMemberRepository;
        }

        /**
         * @return RoleQueries
         */
        public function getRoleQueries(): RoleQueries {
            return $this->roleQueries;
        }

        /**
         * @return AddTeamMember
         */
        public function getAddTeamMember(): AddTeamMember {
            return $this->addTeamMember;
        }
    }