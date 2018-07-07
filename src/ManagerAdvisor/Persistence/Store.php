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
         * @var TeamMemberEntity[]
         */
        private $teamMembers;

        /**
         * Store constructor.
         * @param RoleEntity[] $roles
         * @param StrategyEntity[] $strategies
         * @param TeamMemberEntity[] $teamMembers
         */
        public function __construct(array $roles = [], array $strategies = [], array $teamMembers = []) {
            $this->roles = $roles;
            $this->strategies = $strategies;
            $this->teamMembers = $teamMembers;
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

        /**
         * @return TeamMemberEntity[]
         */
        public function getTeamMembers(): array {
            return $this->teamMembers;
        }

        /**
         * @param TeamMemberEntity[] $teamMembers
         */
        public function setTeamMembers(array $teamMembers): void {
            $this->teamMembers = $teamMembers;
        }

        public function addTeamMember(TeamMemberEntity $teamMemberEntity): void {
            $this->teamMembers[] = $teamMemberEntity;
        }

    }