<?php
    declare(strict_types=1);

    namespace ManagerAdvisor\Domain;
    use RuntimeException;

    class DuplicateUniformNumberException extends RuntimeException{
        const CODE = 0;

        public function __construct(int $uniformNumber) {
            $message = "Already exist a team member with uniform number $uniformNumber";
            parent::__construct($message, self::CODE);
        }
    }