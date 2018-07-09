<?php
    declare(strict_types=1);
    namespace ManagerAdvisor\Domain;

    interface TeamMemberRepositoryInterface {
        public function findByUniformNumber(int $uniformNUmber): ?TeamMember;
        public function findAll(TeamMemberOrder $teamMemberOrder): array;
        public function create(TeamMember $teamMember): void;
        public function deleteByUniformNumber(int $uniformNumber): void;
    }