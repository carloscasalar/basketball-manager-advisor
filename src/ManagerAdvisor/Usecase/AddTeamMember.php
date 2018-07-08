<?php
    declare(strict_types=1);

    namespace ManagerAdvisor\usecase;

    use ManagerAdvisor\Domain\DuplicateUniformNumberException;
    use ManagerAdvisor\Domain\TeamMember;
    use ManagerAdvisor\Domain\TeamMemberRepositoryInterface;

    class AddTeamMember {

        private $teamMemberRepository;

        public function __construct(TeamMemberRepositoryInterface $teamMemberRepository) {
            $this->teamMemberRepository = $teamMemberRepository;
        }

        public function execute(TeamMember $teamMember): void {
            $teamMember->validate();
            $this->assertDoesNotExistOtherMemberWithSameUniformNumber($teamMember->getUniformNumber());

            $this->teamMemberRepository->create($teamMember);
        }

        private function assertDoesNotExistOtherMemberWithSameUniformNumber(int $uniformNumber): void {
            $existingPlayer = $this->teamMemberRepository->findByUniformNumber($uniformNumber);

            if (!is_null($existingPlayer)) {
                throw new DuplicateUniformNumberException($uniformNumber);
            }
        }
    }