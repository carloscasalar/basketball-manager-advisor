<?php

    namespace ManagerAdvisor\Persistence\TeamMemberEntityOrder;

    use ManagerAdvisor\Persistence\TeamMemberEntity;

    class ArbitraryOrder implements TeamMemberSorterInterface {

        const BOTH_TEAMS_HAS_SAME_WEIGHT = 0;

        public function sort(TeamMemberEntity $member, TeamMemberEntity $otherMember): int {
            return self::BOTH_TEAMS_HAS_SAME_WEIGHT;
        }
    }