<?php

    namespace ManagerAdvisor\Tests\Persistence;

    use PHPUnit\Framework\TestCase;

    use Symfony\Component\Filesystem\Filesystem;
    use Symfony\Component\Finder\Finder;

    use ManagerAdvisor\Persistence\StoreManager;

    class StoreManagerTest extends TestCase {

        const TEST_STORE_FOLDER_PATH = 'src/ManagerAdvisor/Resources/Test';
        const STORE_FILE_PATH = self::TEST_STORE_FOLDER_PATH . '/store.json';
        const EMPTY_JSON_CONTENT = '{}';

        /**
         * @var StoreManager
         */
        private $storeManager;

        /**
         * @var Filesystem
         */
        private $fileSystem;

        /**
         * @var Finder
         */
        private $finder;

        protected function setUp() {
            $this->storeManager = new StoreManager(self::TEST_STORE_FOLDER_PATH);
            $this->fileSystem = new Filesystem();
            $this->finder = new Finder();

            $this->cleanTestStoreDir();
        }

        private function cleanTestStoreDir() {
            $this->fileSystem->remove(self::STORE_FILE_PATH);
        }

        /**
         * @test
         */
        public function store_initialization_should_write_new_store_file_if_it_does_not_exists() {
            $existsStoreFileBeforeInit = $this->fileSystem->exists(self::STORE_FILE_PATH);

            $this->storeManager->init();

            $existsStoreFileAfterInit = $this->fileSystem->exists(self::STORE_FILE_PATH);

            self::assertFalse($existsStoreFileBeforeInit, "before store initialization should not be any file in store folder");
            self::assertTrue($existsStoreFileAfterInit, "after initialization should default store file should be written");
        }

        /**
         * @test
         */
        public function store_initialization_should_not_override_existing_store_file() {
            $this->fileSystem->dumpFile(self::STORE_FILE_PATH, self::EMPTY_JSON_CONTENT);

            $this->storeManager->init();

            $fileSearch = $this->finder->in(self::TEST_STORE_FOLDER_PATH)->name('store.json');

            $storeContent = null;
            foreach ($fileSearch as $file) {
                $storeContent = $file->getContents();
            }

            self::assertEquals(self::EMPTY_JSON_CONTENT, $storeContent, "Store file should not be override");
        }

        /**
         * @test
         */
        public function should_load_roles() {
            $storeContent = '{"roles":[{"code":"A","description":"DESCRIPTION"}],"strategies":[]}';
            $this->persistStoreFile($storeContent);

            $store = $this->storeManager->load();

            self::assertNotNull($store, "Store should be loaded");
            self::assertNotEmpty($store->getRoles(), "Roles should be loaded");
            self::assertEquals("A", $store->getRoles()[0]->getCode());
            self::assertEquals("DESCRIPTION", $store->getRoles()[0]->getDescription());
        }

        /**
         * @test
         */
        public function should_load_strategies() {
            $storeContent = '{"roles":[],"strategies":[{"isEditable":false,"code":"Strategy A","positions":["A","A","A","A","A"]}]}';
            $this->persistStoreFile($storeContent);

            $store = $this->storeManager->load();

            self::assertNotNull($store, "Store should be loaded");
            self::assertNotEmpty($store->getStrategies(), "Strategies should be loaded");
            $strategy = $store->getStrategies()[0];
            self::assertEquals(false,$strategy->isEditable(), "Strategy editable value should be restored");
            self::assertEquals("Strategy A", $strategy->getCode(), "Strategy code should be restored");
            self::assertEquals(["A", "A", "A","A","A"], $strategy->getPositions(), "Strategy positions should be restored");
        }

        public function tearDown() {
            parent::tearDown();
            $this->fileSystem->remove(self::STORE_FILE_PATH);
        }

        private function persistStoreFile(string $storeContent): void {
            $this->fileSystem->dumpFile(self::STORE_FILE_PATH, $storeContent);
        }
    }