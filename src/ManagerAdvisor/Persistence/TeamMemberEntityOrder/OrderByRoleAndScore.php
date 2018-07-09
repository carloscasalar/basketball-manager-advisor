<?php

    namespace ManagerAdvisor\Persistence\TeamMemberEntityOrder;


    use ManagerAdvisor\Persistence\RoleEntity;
    use ManagerAdvisor\Persistence\TeamMemberEntity;

    class OrderByRoleAndScore implements TeamMemberSorterInterface {

        /**
         * @var array
         */
        private $rolesDescriptions;

        public function __construct($roles) {
            $this->rolesDescriptions = $this->getRoleDescriptions($roles);
        }

        public function sort(TeamMemberEntity $team, TeamMemberEntity $otherTeam): int {
            $teamRoleDescription = $this->getRoleDescription($team->getRole());
            $otherTeamRoleDescription = $this->getRoleDescription($otherTeam->getRole());

            $comparision = strcmp($teamRoleDescription, $otherTeamRoleDescription);

            if($comparision === 0){
                $comparision = $otherTeam->getCoachScore() - $team->getCoachScore();
            }

            return $comparision;
        }

        private function getRoleDescription(string $code): string {
            return $this->rolesDescriptions[$code];
        }

        private function getRoleDescriptions(array $roles):array {
            return array_reduce(
                $roles,
                function (array $descriptions, RoleEntity $role) {
                    $descriptions[$role->getCode()] = $role->getDescription();
                    return $descriptions;
                },
                []
            );
        }
    }