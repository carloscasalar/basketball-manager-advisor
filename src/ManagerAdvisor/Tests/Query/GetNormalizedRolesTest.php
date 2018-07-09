<?php

    namespace ManagerAdvisor\Tests;

    use ManagerAdvisor\Domain\Role;
    use ManagerAdvisor\Domain\RoleRepositoryInterface;
    use ManagerAdvisor\Query\GetNormalizedRoles;
    use Mockery;
    use PHPUnit\Framework\TestCase;

    class GetNormalizedRolesTest extends TestCase {

        /**
         * @var GetNormalizedRoles
         */
        private $getNormalizedRoles;

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

            $this->getNormalizedRoles = new GetNormalizedRoles($this->roleRepository);

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
            $roles = $this->getNormalizedRoles->execute();

            self::assertEquals($this->normalizedRoles, $roles, 'Should return roles from repository');
        }

        public function tearDown() {
            parent::tearDown();
            Mockery::close();
        }
    }