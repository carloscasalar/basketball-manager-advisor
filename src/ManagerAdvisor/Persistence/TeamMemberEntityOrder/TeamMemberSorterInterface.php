<?php

    namespace ManagerAdvisor\Persistence\TeamMemberEntityOrder;

    use ManagerAdvisor\Persistence\TeamMemberEntity;

    interface TeamMemberSorterInterface {
        public function sort(TeamMemberEntity $member, TeamMemberEntity $otherMember): int;
    }