<?php
    namespace ManagerAdvisor\Query;


    use ManagerAdvisor\Domain\RoleRepositoryInterface;

    class GetNormalizedRoles {
        const DEFAULT_IDEAL_ROLE_CODE = 'PG';

        /**
         * @var RoleRepositoryInterface
         */
        private $roleRepository;

        public function __construct(RoleRepositoryInterface $roleRepository) {
            $this->roleRepository = $roleRepository;
        }

        public function execute():array {
            return $this->roleRepository->getNormalizedRoles();
        }

    }