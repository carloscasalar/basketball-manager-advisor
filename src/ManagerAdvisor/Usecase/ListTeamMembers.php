<?php

    namespace ManagerAdvisor\Usecase;

    use ManagerAdvisor\Domain\TeamMember;
    use ManagerAdvisor\Domain\TeamMemberOrder;
    use ManagerAdvisor\Domain\TeamMemberRepositoryInterface;

    class ListTeamMembers {
        /**
         * @var TeamMemberRepositoryInterface
         */
        private $teamMemberRepository;

        public function __construct(TeamMemberRepositoryInterface $teamMemberRepository) {
            $this->teamMemberRepository = $teamMemberRepository;
        }

        /**
         * @param TeamMemberOrder $teamMemberOrder
         * @return TeamMember[]
         */
        public function execute(TeamMemberOrder $teamMemberOrder): array {
            return $this->teamMemberRepository->findAll($teamMemberOrder);
        }

    }
