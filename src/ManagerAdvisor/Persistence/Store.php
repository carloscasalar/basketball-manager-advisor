<?php

    namespace ManagerAdvisor\Persistence;


    class Store {
        /**
         * @var RoleEntity[]
         */
        private $roles;

        /**
         * @var StrategyEntity[]
         */
        private $strategies;

        /**
         * Store constructor.
         * @param RoleEntity[] $roles
         * @param StrategyEntity[] $strategies
         */
        public function __construct(array $roles, array $strategies) {
            $this->roles = $roles;
            $this->strategies = $strategies;
        }

        /**
         * @return RoleEntity[]
         */
        public function getRoles(): array {
            return $this->roles;
        }

        /**
         * @param RoleEntity[] $roles
         */
        public function setRoles(array $roles): void {
            $this->roles = $roles;
        }

        /**
         * @return StrategyEntity[]
         */
        public function getStrategies(): array {
            return $this->strategies;
        }

        /**
         * @param StrategyEntity[] $strategies
         */
        public function setStrategies(array $strategies): void {
            $this->strategies = $strategies;
        }
    }