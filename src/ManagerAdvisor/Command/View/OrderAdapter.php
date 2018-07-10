<?php
    namespace ManagerAdvisor\Command\View;

    use ManagerAdvisor\Domain\TeamMemberOrder;

    class OrderAdapter {
        private $teamMemberOrderMap;

        public function __construct() {
            $this->teamMemberOrderMap = [
                OrderOptions::ARBITRARY => TeamMemberOrder::arbitrary(),
                OrderOptions::UNIFORM_NUMBER => TeamMemberOrder::byUniformNumber(),
                OrderOptions::ROLE_AND_SCORE => TeamMemberOrder::byRoleAndScore()
            ];
        }

        public function toTeamMemberOrder(string $orderOption):?TeamMemberOrder {
            if(!array_key_exists($orderOption, $this->teamMemberOrderMap)){
                return null;
            }

            return $this->teamMemberOrderMap[$orderOption];
        }
    }