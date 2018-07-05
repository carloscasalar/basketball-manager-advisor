<?php
    declare(strict_types=1);

    namespace ManagerAdvisor\Domain;

    class TeamMember {
        private const MAX_COACH_SCORE = 100;
        private const MIN_COACH_SCORE = 0;

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

        public function validate(): void {
            if ($this->isScoreOverLimit()) {
                throw new InvalidScoreException($this->coachScore);
            }

            if($this->isScoreUnderLimit()){
                throw new InvalidScoreException($this->coachScore);
            }
        }

        private function isScoreOverLimit(): bool {
            return $this->coachScore > self::MAX_COACH_SCORE;
        }

        private function isScoreUnderLimit(): bool {
            return $this->coachScore < self::MIN_COACH_SCORE;
        }
    }