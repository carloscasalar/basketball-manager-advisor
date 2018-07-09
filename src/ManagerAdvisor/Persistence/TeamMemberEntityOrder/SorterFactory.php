<?php

    namespace ManagerAdvisor\Persistence\TeamMemberEntityOrder;

    use ManagerAdvisor\Domain\TeamMemberOrder;
    use ManagerAdvisor\Persistence\RoleEntity;

    class SorterFactory {
        /**
         * @var array
         */
        private $sorters;

        /**
         * @var RoleEntity[]
         */
        private $roles;

        public function __construct(array $roles) {
            $this->sorters = [
                TeamMemberOrder::ARBITRARY => new ArbitraryOrder(),
                TeamMemberOrder::UNIFORM_NUMBER => new OrderByUniformNumber()
            ];

            $this->roles = $roles;
        }

        public function getSorter(TeamMemberOrder $teamMemberOrder): TeamMemberSorterInterface{
            return $this->sorters[$teamMemberOrder->getCriteria()];
        }
    }