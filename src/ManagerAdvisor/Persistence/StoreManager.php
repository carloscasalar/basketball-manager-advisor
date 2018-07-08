<?php

    namespace ManagerAdvisor\Persistence;

    use Symfony\Component\Filesystem\Filesystem;
    use Symfony\Component\Finder\Finder;
    use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
    use Symfony\Component\Serializer\Serializer;
    use Symfony\Component\Serializer\Encoder\JsonEncoder;

    class StoreManager {
        const DEFAULT_STORE_FILE = 'resources/defaults/store.json';
        const STORE_FILE_NAME = 'store.json';

        private $storePath;
        private $fileSystem;
        private $serializer;
        private $cachedStore;

        public function __construct(string $storePath) {
            $this->storePath = $storePath;
            $this->fileSystem = new Filesystem();
            $this->serializer = $this->getSerializer();
        }

        public function init(): void {
            $this->fileSystem->copy(self::DEFAULT_STORE_FILE, $this->storeFilePath());
        }

        public function load(bool $ignoreCache = false): Store {
            if($this->isStoreCached() && !$ignoreCache){
                return $this->cachedStore;
            }

            $normalizedStoreContent = $this->parseStoreFile();

            $roles = $this->getRoles($normalizedStoreContent);

            $strategies = $this->getStrategies($normalizedStoreContent);

            $teamMembers = $this->getTeamMembers($normalizedStoreContent);

            $this->cachedStore = new Store($roles, $strategies, $teamMembers);

            return $this->cachedStore;
        }

        public function persist($store): void {
            $storeContent = $this->serializer->serialize($store, 'json');
            $this->fileSystem->dumpFile($this->storeFilePath(), $storeContent);
        }

        private function storeFilePath(): string {
            return $this->storePath . '/' . self::STORE_FILE_NAME;
        }

        private function parseStoreFile(): array {
            $finder = new Finder();
            $fileSearch = $finder->in($this->storePath)->name(self::STORE_FILE_NAME);

            $storeContent = null;
            foreach ($fileSearch as $file) {
                $storeContent = $file->getContents();
            }

            if ($storeContent == null) {
                throw new \RuntimeException("store file not found. Maybe you forget call StoreManager::init");
            }
            $normalizedStoreContent = json_decode($storeContent, true);
            return $normalizedStoreContent;
        }

        private function getSerializer(): Serializer {
            $encoders = array(new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);
            return $serializer;
        }

        private function getRoles($normalizedStoreContent): array {
            return array_map(
                function (array $normalizedRole) {
                    return $this->serializer->denormalize($normalizedRole, RoleEntity::class);
                },
                $normalizedStoreContent['roles']
            );
        }

        private function getStrategies($normalizedStoreContent): array {
            return array_map(
                function (array $normalizedStrategy) {
                    return $this->serializer->denormalize($normalizedStrategy, StrategyEntity::class);
                },
                $normalizedStoreContent['strategies']
            );
        }

        private function getTeamMembers($normalizedStoreContent): array {
            return array_map(
                function (array $normalizedTeamMember) {
                    return $this->serializer->denormalize($normalizedTeamMember, TeamMemberEntity::class);
                },
                $normalizedStoreContent['teamMembers']
            );
        }

        private function isStoreCached(): bool {
            return !is_null($this->cachedStore);
        }
    }