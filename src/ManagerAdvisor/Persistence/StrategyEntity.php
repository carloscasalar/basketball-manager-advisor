<?php

    namespace ManagerAdvisor\Persistence;

    class StrategyEntity {
        /**
         * @var bool
         */
        private $editable;

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
         * @param bool $editable
         * @param string $code
         * @param string[] $positions
         */
        public function __construct(bool $editable, string $code, array $positions) {
            $this->editable = $editable;
            $this->code = $code;
            $this->positions = $positions;
        }

        /**
         * @return bool
         */
        public function isEditable(): bool {
            return $this->editable;
        }

        /**
         * @param bool $editable
         */
        public function setEditable(bool $editable): void {
            $this->editable = $editable;
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