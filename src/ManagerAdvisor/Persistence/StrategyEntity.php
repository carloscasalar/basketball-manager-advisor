<?php

    namespace ManagerAdvisor\Persistence;

    class StrategyEntity {
        /**
         * @var bool
         */
        private $isEditable;

        /**
         * @var string
         */
        private $code;

        /**
         * @var string[]
         */
        private $positions;

        /**
         * StrategyEntity constructor.
         * @param bool $isEditable
         * @param string $code
         * @param string[] $positions
         */
        public function __construct(bool $isEditable, string $code, array $positions) {
            $this->isEditable = $isEditable;
            $this->code = $code;
            $this->positions = $positions;
        }

        /**
         * @return bool
         */
        public function isEditable(): bool {
            return $this->isEditable;
        }

        /**
         * @param bool $isEditable
         */
        public function setIsEditable(bool $isEditable): void {
            $this->isEditable = $isEditable;
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
         * @return string[]
         */
        public function getPositions(): array {
            return $this->positions;
        }

        /**
         * @param string[] $positions
         */
        public function setPositions(array $positions): void {
            $this->positions = $positions;
        }

    }