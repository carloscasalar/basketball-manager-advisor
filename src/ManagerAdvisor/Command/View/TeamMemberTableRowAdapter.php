<?php
    namespace ManagerAdvisor\Command\View;

    use ManagerAdvisor\Domain\TeamMember;

    class TeamMemberTableRowAdapter {
        public function toTableRow(TeamMember $teamMember): array {
            return array(
                $teamMember->getUniformNumber(),
                $teamMember->getName(),
                $teamMember->getIdealRole()->getDescription(),
                $teamMember->getCoachScore()
            );
        }

        public function toTableRowCallback(): callable {
            return array($this, 'toTableRow');
        }
    }