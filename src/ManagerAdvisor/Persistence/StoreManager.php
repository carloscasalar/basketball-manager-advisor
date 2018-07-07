<?php

    namespace ManagerAdvisor\Persistence;

    use ManagerAdvisor\Domain\Role;
    use Symfony\Component\Filesystem\Filesystem;
    use Symfony\Component\Finder\Finder;
    use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
    use Symfony\Component\Serializer\Serializer;
    use Symfony\Component\Serializer\Encoder\JsonEncoder;
    use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

    class StoreManager {
        const DEFAULT_STORE_FILE = 'src/ManagerAdvisor/Resources/Defaults/store.json';
        const STORE_FILE_NAME = 'store.json';

        private $storePath;
        private $fileSystem;
        private $store;

        public function __construct(string $storePath) {
            $this->storePath = $storePath;
            $this->fileSystem = new Filesystem();
        }

        public function init(): void {
            $this->fileSystem->copy(self::DEFAULT_STORE_FILE, $this->storeFilePath());
        }

        public function load(): Store {
            $finder = new Finder();
            $fileSearch = $finder->in($this->storePath)->name(self::STORE_FILE_NAME);

            $storeContent=null;
            foreach ($fileSearch as $file){
                $storeContent = $file->getContents();
            }

            if($storeContent==null){
                throw new \RuntimeException("store file not found. Maybe you forget call StoreManager::init");
            }
            $normalizedStoreContent = json_decode($storeContent, true);

            $encoders = array(new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);


            $roles = [];
            foreach ($normalizedStoreContent['roles'] as $roleArray){
                $roles[] = $serializer->denormalize($roleArray, Role::class);
            }

            return new Store($roles, []);
        }

        private function storeFilePath(): string {
            return $this->storePath . '/' . self::STORE_FILE_NAME;
        }
    }