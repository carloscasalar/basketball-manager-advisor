<?php
    declare(strict_types=1);

    namespace ManagerAdvisor\Domain;
    use RuntimeException;

    class DuplicateUniformNameException extends RuntimeException{
        const CODE = 0;

        public function __construct(int $score) {
            $message = "Already exist a team member with uniform number $score";
            parent::__construct($message, self::CODE);
        }
    }