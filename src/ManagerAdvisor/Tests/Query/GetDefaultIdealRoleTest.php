<?php

    namespace ManagerAdvisor\Tests;

    use ManagerAdvisor\Domain\Role;
    use ManagerAdvisor\Domain\RoleRepositoryInterface;
    use ManagerAdvisor\Query\GetDefaultIdealRole;
    use Mockery;
    use PHPUnit\Framework\TestCase;

    class GetDefaultIdealRoleTest extends TestCase {

        /**
         * @var GetDefaultIdealRole
         */
        private $getDefaultIdealRole;

        /**
         * @var RoleRepositoryInterface
         */
        private $roleRepository;

        /**
         * @var Role
         */
        private $defaultIdealRole;

        protected function setUp() {
            $this->roleRepository = Mockery::mock(RoleRepositoryInterface::class);

            $this->getDefaultIdealRole = new GetDefaultIdealRole($this->roleRepository);

            $this->defaultIdealRole = new Role('PG', 'Point Guard');

            $normalizedRoles = [
                'A' => new Role("A", "Role A"),
                'B' => new Role("B", "Role B"),
                $this->defaultIdealRole->getCode() => $this->defaultIdealRole
            ];

            $this->roleRepository->expects()->getNormalizedRoles()->andReturns($normalizedRoles);
        }

        /**
         * @test
         */
        public function should_return_default_ideal_role() {
            $defaultRole = $this->getDefaultIdealRole->execute();

            self::assertEquals($this->defaultIdealRole, $defaultRole, 'Should return Point Guard as default ideal role');
        }

        public function tearDown() {
            parent::tearDown();
            Mockery::close();
        }
    }