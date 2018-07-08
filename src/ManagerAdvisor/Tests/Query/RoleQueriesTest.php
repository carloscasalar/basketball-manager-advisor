<?php

    namespace ManagerAdvisor\Tests;

    use ManagerAdvisor\Domain\Role;
    use ManagerAdvisor\Domain\RoleRepositoryInterface;
    use ManagerAdvisor\Query\RoleQueries;
    use Mockery;
    use PHPUnit\Framework\TestCase;

    class RoleQueriesTest extends TestCase {

        /**
         * @var RoleQueries
         */
        private $roleQueries;

        /**
         * @var RoleRepositoryInterface
         */
        private $roleRepository;

        /**
         * @var Role[]
         */
        private $normalizedRoles;

        /**
         * @var Role
         */
        private $defaultIdealRole;

        protected function setUp() {
            $this->roleRepository = Mockery::mock(RoleRepositoryInterface::class);

            $this->roleQueries = new RoleQueries($this->roleRepository);

            $this->defaultIdealRole = new Role('PG', 'Point Guard');

            $this->normalizedRoles = [
                'A' => new Role("A", "Role A"),
                'B' => new Role("B", "Role B"),
                $this->defaultIdealRole->getCode() => $this->defaultIdealRole
            ];

            $this->roleRepository->expects()->getNormalizedRoles()->andReturns($this->normalizedRoles);
        }

        /**
         * @test
         */
        public function should_return_repository_role_list() {
            $roles = $this->roleQueries->getNormalizedRoles();

            self::assertEquals($this->normalizedRoles, $roles, 'Should return roles from repository');
        }

        /**
         * @test
         */
        public function should_return_default_ideal_role() {
            $defaultRole = $this->roleQueries->getDefaultIdealRole();

            self::assertEquals($this->defaultIdealRole, $defaultRole, 'Should return Point Guard as default ideal role');
        }

        public function tearDown() {
            parent::tearDown();
            Mockery::close();
        }
    }