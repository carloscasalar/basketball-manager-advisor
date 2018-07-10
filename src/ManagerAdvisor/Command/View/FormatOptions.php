<?php
    namespace ManagerAdvisor\Command\View;

    class FormatOptions {
        const TABLE = 'TABLE';
        const JSON = 'JSON';

        const DEFAULT = self::TABLE;

        public function isInvalid($format): bool{
            return !in_array($format, [self::TABLE, self::JSON]);
        }
    }