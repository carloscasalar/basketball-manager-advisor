<?php
    namespace ManagerAdvisor\Domain;


    class TeamMemberOrder {
        const ARBITRARY = 'ARBITRARY';
        const UNIFORM_NUMBER = 'UNIFORM_NUMBER';
        const ROLE_AND_SCORE = 'ROLE_AND_SCORE';

        /**
         * @var string
         */
        private $criteria;

        private function __construct($criteria) {
            $this->criteria = $criteria;
        }

        /**
         * @return string
         */
        public function getCriteria(): string {
            return $this->criteria;
        }

        public static function arbitrary(): TeamMemberOrder{
            return new TeamMemberOrder(self::ARBITRARY);
        }

        public static function byUniformNumber(): TeamMemberOrder{
            return new TeamMemberOrder(self::UNIFORM_NUMBER);
        }

        public static function byRoleAndScore(): TeamMemberOrder{
            return new TeamMemberOrder(self::ROLE_AND_SCORE);
        }
    }