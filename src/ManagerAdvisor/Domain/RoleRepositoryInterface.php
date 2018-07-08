<?php
    namespace ManagerAdvisor\Domain;

    interface RoleRepositoryInterface {
        public function getNormalizedRoles(): array;
    }