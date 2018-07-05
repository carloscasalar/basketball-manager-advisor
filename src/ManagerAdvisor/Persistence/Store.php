<?php

    namespace ManagerAdvisor\Persistence;

    use Symfony\Component\Filesystem\Filesystem;

    class Store {
        const DEFAULT_STORE_FILE = 'src/ManagerAdvisor/Resources/Defaults/store.json';
        const STORE_FILE_NAME = 'store.json';

        private $storePath;
        private $fileSystem;

        public function __construct(string $storePath) {
            $this->storePath = $storePath;
            $this->fileSystem = new Filesystem();
        }

        public function init(): void {
            $this->fileSystem->copy(self::DEFAULT_STORE_FILE, $this->storeFilePath());
        }

        private function storeFilePath(): string {
            return $this->storePath . '/' . self::STORE_FILE_NAME;
        }
    }