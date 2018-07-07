<?php

    namespace ManagerAdvisor\Persistence;

    class RoleEntity {
        /**
         * @var string
         */
        private $code;

        /**
         * @var string
         */
        private $description;

        /**
         * RoleEntity constructor.
         * @param string $code
         * @param string $description
         */
        public function __construct(string $code, string $description) {
            $this->code = $code;
            $this->description = $description;
        }

        /**
         * @return string
         */
        public function getCode(): string {
            return $this->code;
        }

        /**
         * @param string $code
         */
        public function setCode(string $code): void {
            $this->code = $code;
        }

        /**
         * @return string
         */
        public function getDescription(): string {
            return $this->description;
        }

        /**
         * @param string $description
         */
        public function setDescription(string $description): void {
            $this->description = $description;
        }
    }