<?php

    namespace ManagerAdvisor\Persistence\TeamMemberEntityOrder;

    use ManagerAdvisor\Domain\TeamMemberOrder;

    class SorterFactory {
        /**
         * @var array
         */
        private $sorters;

        public function __construct(array $roles) {
            $this->sorters = [
                TeamMemberOrder::ARBITRARY => new ArbitraryOrder(),
                TeamMemberOrder::UNIFORM_NUMBER => new OrderByUniformNumber(),
                TeamMemberOrder::ROLE_AND_SCORE => new OrderByRoleAndScore($roles)
            ];
        }

        public function getSorter(TeamMemberOrder $teamMemberOrder): TeamMemberSorterInterface {
            return $this->sorters[$teamMemberOrder->getCriteria()];
        }
    }