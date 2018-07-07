<?php

    namespace ManagerAdvisor\Persistence;

    use Symfony\Component\Filesystem\Filesystem;
    use Symfony\Component\Finder\Finder;
    use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
    use Symfony\Component\Serializer\Serializer;
    use Symfony\Component\Serializer\Encoder\JsonEncoder;

    class StoreManager {
        const DEFAULT_STORE_FILE = 'src/ManagerAdvisor/Resources/Defaults/store.json';
        const STORE_FILE_NAME = 'store.json';

        private $storePath;
        private $fileSystem;
        private $serializer;

        public function __construct(string $storePath) {
            $this->storePath = $storePath;
            $this->fileSystem = new Filesystem();
            $this->serializer = $this->getSerializer();
        }

        public function init(): void {
            $this->fileSystem->copy(self::DEFAULT_STORE_FILE, $this->storeFilePath());
        }

        public function load(): Store {
            $normalizedStoreContent = $this->parseStoreFile();

            $roles = $this->getRoles($normalizedStoreContent);

            $strategies = $this->getStrategies($normalizedStoreContent);

            return new Store($roles, $strategies);
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
            $roles = [];
            foreach ($normalizedStoreContent['roles'] as $roleArray) {
                $roles[] = $this->serializer->denormalize($roleArray, RoleEntity::class);
            }
            return $roles;
        }

        private function getStrategies($normalizedStoreContent): array {
            $strategies = [];
            foreach ($normalizedStoreContent['strategies'] as $strategyArray) {
                $strategies[] = $this->serializer->denormalize($strategyArray, StrategyEntity::class);
            }
            return $strategies;
        }
    }