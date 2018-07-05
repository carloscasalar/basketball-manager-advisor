<?php
    declare(strict_types=1);
    namespace ManagerAdvisor\Domain;

    class Role {
        private $code;
        private $description;

        public function __construct($code, $description) {
            $this->code = $code;
            $this->description = $description;
        }

        public function getCode(): string {
            return $this->code;
        }

        public function getDescription(): string {
            return $this->description;
        }
    }