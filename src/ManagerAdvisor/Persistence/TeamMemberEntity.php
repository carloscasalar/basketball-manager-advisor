<?php

    namespace ManagerAdvisor\Persistence;

    class TeamMemberEntity {
        /**
         * @var int
         */
        private $uniformNumber;

        /**
         * @var string
         */
        private $name;

        /**
         * @var string
         */
        private $role;

        /**
         * @var int
         */
        private $coachScore;

        /**
         * TeamMemberEntity constructor.
         * @param int $uniformNumber
         * @param string $name
         * @param string $role
         * @param int $coachScore
         */
        public function __construct(int $uniformNumber, string $name, string $role, int $coachScore) {
            $this->uniformNumber = $uniformNumber;
            $this->name = $name;
            $this->role = $role;
            $this->coachScore = $coachScore;
        }

        /**
         * @return int
         */
        public function getUniformNumber(): int {
            return $this->uniformNumber;
        }

        /**
         * @param int $uniformNumber
         */
        public function setUniformNumber(int $uniformNumber): void {
            $this->uniformNumber = $uniformNumber;
        }

        /**
         * @return string
         */
        public function getName(): string {
            return $this->name;
        }

        /**
         * @param string $name
         */
        public function setName(string $name): void {
            $this->name = $name;
        }

        /**
         * @return string
         */
        public function getRole(): string {
            return $this->role;
        }

        /**
         * @param string $role
         */
        public function setRole(string $role): void {
            $this->role = $role;
        }

        /**
         * @return int
         */
        public function getCoachScore(): int {
            return $this->coachScore;
        }

        /**
         * @param int $coachScore
         */
        public function setCoachScore(int $coachScore): void {
            $this->coachScore = $coachScore;
        }
    }