<?php

    namespace ManagerAdvisor\Persistence;

    use ManagerAdvisor\Domain\Role;

    class RoleAdapter {
        public function toRole(RoleEntity $roleEntity): Role {
            return new Role($roleEntity->getCode(), $roleEntity->getDescription());
        }
    }