<?php

    namespace ManagerAdvisor\Persistence;

    use ManagerAdvisor\Domain\TeamMember;

    class TeamMemberAdapter {
        public function toTeamMember(TeamMemberEntity $teamMemberEntity, array $normalizedRoles): TeamMember {
            return new TeamMember(
                $teamMemberEntity->getUniformNumber(),
                $teamMemberEntity->getName(),
                $normalizedRoles[$teamMemberEntity->getRole()],
                $teamMemberEntity->getCoachScore()
            );
        }

        public function toTeamMemberEntity(TeamMember $teamMember): TeamMemberEntity {
            return new TeamMemberEntity(
              $teamMember->getUniformNumber(),
              $teamMember->getName(),
              $teamMember->getIdealRole()->getCode(),
              $teamMember->getCoachScore()
            );
        }
    }