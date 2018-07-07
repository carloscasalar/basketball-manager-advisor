<?php

    namespace ManagerAdvisor\Persistence;

    class RoleRepository {
        private $roleAdapter;

        /**
         * RoleRepository constructor.
         */
        public function __construct() {
            $this->roleAdapter = new RoleAdapter();
        }

        public function getNormalizedRoles(Store $store): array{
            return array_reduce($store->getRoles(), function(array $normalized, RoleEntity $role){
                $normalized[$role->getCode()] = $this->roleAdapter->toRole($role);
                return $normalized;
            }, []);
        }
    }