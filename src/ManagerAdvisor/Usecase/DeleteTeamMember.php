<?php
    namespace ManagerAdvisor\Usecase;

    use ManagerAdvisor\Domain\DoesNotExistsTeamMemberWithUniformNumberException;
    use ManagerAdvisor\Domain\TeamMemberRepositoryInterface;

    class DeleteTeamMember {
        /**
         * @var TeamMemberRepositoryInterface
         */
        private $teamMemberRepository;

        public function __construct($teamMemberRepository) {
            $this->teamMemberRepository = $teamMemberRepository;
        }

        public function execute(int $uniformNumber): void {
            $teamMember = $this->teamMemberRepository->findByUniformNumber($uniformNumber);

            if(is_null($teamMember)){
                throw new DoesNotExistsTeamMemberWithUniformNumberException($uniformNumber);
            }

            $this->teamMemberRepository->deleteByUniformNumber($uniformNumber);
        }

    }
