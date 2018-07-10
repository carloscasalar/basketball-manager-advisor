<?php
    namespace ManagerAdvisor\Command\View;


    class TeamMemberView {
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
        private $idealRole;
        /**
         * @var int
         */
        private $coachScore;

        /**
         * @param int $uniformNumber
         * @param string $name
         * @param string $idealRole
         * @param int $coachScore
         */
        public function __construct(int $uniformNumber, string $name, string $idealRole, int $coachScore) {
            $this->uniformNumber = $uniformNumber;
            $this->name = $name;
            $this->idealRole = $idealRole;
            $this->coachScore = $coachScore;
        }

        /**
         * @return int
         */
        public function getUniformNumber(): int {
            return $this->uniformNumber;
        }

        /**
         * @return string
         */
        public function getName(): string {
            return $this->name;
        }

        /**
         * @return string
         */
        public function getIdealRole(): string {
            return $this->idealRole;
        }

        /**
         * @return int
         */
        public function getCoachScore(): int {
            return $this->coachScore;
        }
    }