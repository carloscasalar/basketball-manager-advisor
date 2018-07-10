<?php

    namespace ManagerAdvisor\Persistence\TeamMemberEntityOrder;

    use ManagerAdvisor\Persistence\TeamMemberEntity;

    class OrderByUniformNumber implements TeamMemberSorterInterface {

        public function sort(TeamMemberEntity $member, TeamMemberEntity $otherMember): int {
            return $this->compare($member->getUniformNumber(), $otherMember->getUniformNumber());
        }

        private function compare($uniformNumber, $otherUniformNumber) {
            return $uniformNumber - $otherUniformNumber;
        }
    }