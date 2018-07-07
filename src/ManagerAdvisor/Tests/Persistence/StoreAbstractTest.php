<?php
    namespace ManagerAdvisor\Tests\Persistence;

    use ManagerAdvisor\Persistence\StoreManager;
    use PHPUnit\Framework\TestCase;
    use Symfony\Component\Filesystem\Filesystem;

    abstract class StoreAbstractTest extends TestCase {

        const TEST_STORE_FOLDER_PATH = 'src/ManagerAdvisor/Resources/Test';
        const STORE_FILE_PATH = self::TEST_STORE_FOLDER_PATH . '/store.json';

        /**
         * @var StoreManager
         */
        protected $storeManager;

        /**
         * @var Filesystem
         */
        private $fileSystem;

        protected function setUp() {
            $this->fileSystem = new Filesystem();
            $this->storeManager = new StoreManager(self::TEST_STORE_FOLDER_PATH);
            $this->cleanTestStoreDir();
        }

        protected function tearDown() {
            parent::tearDown();
            $this->fileSystem->remove(self::STORE_FILE_PATH);
        }

        private function cleanTestStoreDir() {
            $this->fileSystem->remove(self::STORE_FILE_PATH);
        }
    }