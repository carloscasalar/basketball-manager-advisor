<?php
    namespace ManagerAdvisor\Command\Printer;

    use ManagerAdvisor\Domain\TeamMember;

    interface PrinterInterface {
        /**
         * @param TeamMember[] $teamMembers
         */
        public function render(array $teamMembers):void;
    }