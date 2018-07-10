<?php
    namespace ManagerAdvisor\Command\View;

    use ManagerAdvisor\Domain\TeamMember;

    class TeamMemberViewAdapter {
        public function toTeamMemberView(TeamMember $teamMember): TeamMemberView {
            return new TeamMemberView(
                $teamMember->getUniformNumber(),
                $teamMember->getName(),
                $teamMember->getIdealRole()->getDescription(),
                $teamMember->getCoachScore()
            );
        }

        public function toTeamMemberViewCallback(): callable {
            return array($this, 'toTeamMemberView');
        }
    }