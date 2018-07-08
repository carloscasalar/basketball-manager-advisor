<?php

    namespace ManagerAdvisor\Persistence;

    use ManagerAdvisor\Domain\RoleRepositoryInterface;

    class RoleRepository implements RoleRepositoryInterface {
        /**
         * @var RoleAdapter
         */
        private $roleAdapter;

        /**
         * @var StoreManager
         */
        private $storeManager;

        public function __construct(StoreManager $storeManager) {
            $this->storeManager = $storeManager;
            $this->roleAdapter = new RoleAdapter();
        }

        public function getNormalizedRoles(): array{
            $store = $this->storeManager->load();

            return array_reduce($store->getRoles(), function(array $normalized, RoleEntity $role){
                $normalized[$role->getCode()] = $this->roleAdapter->toRole($role);
                return $normalized;
            }, []);
        }
    }