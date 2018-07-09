<?php
    namespace ManagerAdvisor\Persistence\TeamMemberEntityOrder;

    use ManagerAdvisor\Persistence\TeamMemberEntity;

    class ArbitraryOrder implements TeamMemberSorterInterface {

        const BOTH_TEAMS_HAS_SAME_WEIGHT = 0;

        public function sort(TeamMemberEntity $team, TeamMemberEntity $otherTeam): int {
            return self::BOTH_TEAMS_HAS_SAME_WEIGHT;
        }
    }