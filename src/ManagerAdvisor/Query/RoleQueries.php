<?php
    namespace ManagerAdvisor\Query;


    use ManagerAdvisor\Domain\Role;
    use ManagerAdvisor\Domain\RoleRepositoryInterface;

    class RoleQueries {
        const DEFAULT_IDEAL_ROLE_CODE = 'PG';

        /**
         * @var RoleRepositoryInterface
         */
        private $roleRepository;

        public function __construct(RoleRepositoryInterface $roleRepository) {
            $this->roleRepository = $roleRepository;
        }

        public function getNormalizedRoles():array {
            return $this->roleRepository->getNormalizedRoles();
        }

        public function getDefaultIdealRole(): Role {
            return $this->roleRepository->getNormalizedRoles()[self::DEFAULT_IDEAL_ROLE_CODE];
        }
    }