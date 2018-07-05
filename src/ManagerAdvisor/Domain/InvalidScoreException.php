<?php
    declare(strict_types=1);

    namespace ManagerAdvisor\Domain;
    use RuntimeException;

    class InvalidScoreException extends RuntimeException {
        const CODE = 1;

        public function __construct(int $score) {
            $message = "Invalid score number: $score. Score should be between 0 and 100";
            parent::__construct($message, self::CODE);
        }
    }