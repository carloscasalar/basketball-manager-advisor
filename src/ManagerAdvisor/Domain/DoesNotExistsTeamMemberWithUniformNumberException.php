<?php
    namespace ManagerAdvisor\Domain;

    use RuntimeException;

    class DoesNotExistsTeamMemberWithUniformNumberException extends RuntimeException {
        const CODE = 0;

        public function __construct(int $uniformNumber) {
            $message = "Does not exist a team member with uniform number $uniformNumber";
            parent::__construct($message, self::CODE);
        }
    }