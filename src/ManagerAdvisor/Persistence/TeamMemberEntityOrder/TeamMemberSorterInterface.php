<?php
    namespace ManagerAdvisor\Persistence\TeamMemberEntityOrder;


    use ManagerAdvisor\Persistence\TeamMemberEntity;

    interface TeamMemberSorterInterface {
        public function sort(TeamMemberEntity $team, TeamMemberEntity $otherTeam): int;
    }