<?php

    namespace ManagerAdvisor\Persistence;


    use ManagerAdvisor\Domain\TeamMember;
    use ManagerAdvisor\Domain\TeamMemberRepositoryInterface;

    class TeamMemberRepository implements TeamMemberRepositoryInterface {
        const FIRST_SEARCH_RESULT = 1;

        /**
         * @var StoreManager
         */
        private $storeManager;

        /**
         * @var RoleRepository
         */
        private $roleRepository;

        /**
         * @var TeamMemberAdapter
         */
        private $teamMemberAdapter;

        public function __construct(StoreManager $storeManager, RoleRepository $roleRepository) {
            $this->storeManager = $storeManager;
            $this->roleRepository = $roleRepository;
            $this->teamMemberAdapter = new TeamMemberAdapter();
        }

        public function findByUniformNumber(int $uniformNUmber): ?TeamMember {
            $store = $this->storeManager->load();
            $normalizedRoles = $this->roleRepository->getNormalizedRoles($store);

            $teamMemberEntity = $this->findTeamEntityByUniformNumber($store, $uniformNUmber);

            return empty($teamMemberEntity) ? null : $this->teamMemberAdapter->toTeamMember($teamMemberEntity, $normalizedRoles);
        }

        public function create(TeamMember $teamMember): void {
            $store = $this->storeManager->load();
            $teamMemberEntity = $this->teamMemberAdapter->toTeamMemberEntity($teamMember);
            $store->addTeamMember($teamMemberEntity);
            $this->storeManager->persist($store);
        }

        private function findTeamEntityByUniformNumber(Store $store, int $uniformNUmber): ?TeamMemberEntity {
            $searchMemberResult = array_filter(
                $store->getTeamMembers(),
                function (TeamMemberEntity $teamMember) use ($uniformNUmber) {
                    return $uniformNUmber == $teamMember->getUniformNumber();
                });

            $teamMemberEntity = null;
            if (!empty($searchMemberResult)) {
                $teamMemberEntity = $searchMemberResult[self::FIRST_SEARCH_RESULT];
            }
            return $teamMemberEntity;
        }
    }