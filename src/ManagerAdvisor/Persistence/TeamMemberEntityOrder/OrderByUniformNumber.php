<?php
    namespace ManagerAdvisor\Persistence\TeamMemberEntityOrder;

    use ManagerAdvisor\Persistence\TeamMemberEntity;

    class OrderByUniformNumber implements TeamMemberSorterInterface {

        public function sort(TeamMemberEntity $team, TeamMemberEntity $otherTeam): int {
            return $this->compare($team->getUniformNumber(), $otherTeam->getUniformNumber());
        }

        private function compare($uniformNumber, $otherUniformNumber) {
            return $uniformNumber-$otherUniformNumber;
        }
    }