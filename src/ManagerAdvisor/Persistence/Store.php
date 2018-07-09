<?php

    namespace ManagerAdvisor\Persistence;


    use ManagerAdvisor\Domain\TeamMemberOrder;
    use ManagerAdvisor\Persistence\TeamMemberEntityOrder\SorterFactory;

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

        public function removeTeamMemberByUniformNumber($uniformNumber) {
            $this->teamMembers = array_filter(
                $this->teamMembers,
                function (TeamMemberEntity $teamMember) use ($uniformNumber) {
                    return $teamMember->getUniformNumber() != $uniformNumber;
                }
            );
        }

        public function getOrderedTeamMembers(TeamMemberOrder $order): array {
            $sorterFactory = new SorterFactory($this->roles);
            $sorter = $sorterFactory->getSorter($order);
            $members = $this->teamMembers;

            usort(
                $members,
                function (TeamMemberEntity $member, TeamMemberEntity $otherMember) use ($sorter) {
                    return $sorter->sort($member, $otherMember);
                }
            );

            return $members;
        }

    }