<?php
    declare(strict_types=1);
    namespace ManagerAdvisor\domain;

    class TeamMember {
        private $uniformNumber;
        private $name;
        private $idealRole;
        private $coachScore;

        public function __construct(int $uniformNumber, string $name, Role $idealRole, int $coachScore) {
            $this->uniformNumber = $uniformNumber;
            $this->name = $name;
            $this->idealRole = $idealRole;
            $this->coachScore = $coachScore;
        }

        public function getUniformNumber(): int {
            return $this->uniformNumber;
        }

        public function getName(): string {
            return $this->name;
        }

        public function getIdealRole(): Role {
            return $this->idealRole;
        }

        public function getCoachScore(): int {
            return $this->coachScore;
        }

    }