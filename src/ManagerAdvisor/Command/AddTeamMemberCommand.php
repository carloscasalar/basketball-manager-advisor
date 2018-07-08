<?php

    namespace ManagerAdvisor\Command;

    use ManagerAdvisor\Domain\Role;
    use ManagerAdvisor\Domain\TeamMember;
    use ManagerAdvisor\Injector\Injector;
    use ManagerAdvisor\Query\RoleQueries;
    use ManagerAdvisor\usecase\AddTeamMember;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Question\ChoiceQuestion;
    use Symfony\Component\Console\Question\Question;

    class AddTeamMemberCommand extends Command {
        const UNIFORM_NUMBER = 'uniformNumber';
        const NAME = 'name';

        /**
         * @var RoleQueries
         */
        private $roleQueries;

        /**
         * @var AddTeamMember
         */
        private $addTeamMember;

        public function __construct(Injector $injector) {
            parent::__construct();
            $this->roleQueries = $injector->getRoleQueries();
            $this->addTeamMember = $injector->getAddTeamMember();
        }

        protected function configure() {
            $this
                ->setName('addTeamMember')
                ->setDescription('Add a new team member')
                ->setHelp('This command adds a new member to the team');
        }

        protected function execute(InputInterface $input, OutputInterface $output) {
            $helper = $this->getHelper('question');

            $uniformNumber = $this->askUniformNumber($input, $output, $helper);
            $name = $this->askTeamMemberName($input, $output, $helper);
            $selectedRole = $this->askIdealRole($input, $output, $helper);
            $coachScore = $this->askCoachScore($input, $output, $helper);

            $output->writeln("<info>You entered uniform number $uniformNumber</info>");
            $output->writeln("<info>You entered team member name $name</info>");
            $output->writeln("<info>You selected the role ".$selectedRole->getDescription()."</info>");
            $output->writeln("<info>You entered a coach score of $coachScore</info>");

            $teamMember = new TeamMember(
              $uniformNumber,
              $name,
              $selectedRole,
              $coachScore
            );

            try{
                $this->addTeamMember->execute($teamMember);
                $output->writeln('<bg=green;options=bold>Team member added</>');
            }catch (\Exception $exception){
                $output->writeln('<error>Error: '.$exception->getMessage().'</error>');
            }
        }

        private function askUniformNumber(InputInterface $input, OutputInterface $output, $helper): int {
            $question = new Question('<question>Enter the uniform number: </question>');
            $question->setValidator(function ($answer) {
                if (is_null($answer)) {
                    throw new \RuntimeException('The uniform number is required');
                }
                if (!intval($answer) > 0) {
                    throw new \RuntimeException('The uniform number should be a number');
                }

                return $answer;
            });
            $question->setMaxAttempts(2);

            $uniformNumber = intval($helper->ask($input, $output, $question));
            return $uniformNumber;
        }

        private function askIdealRole(InputInterface $input, OutputInterface $output, $helper): Role {
            $normalizedRoles = $this->roleQueries->getNormalizedRoles();
            $roleDescriptions = array_map(
                function (Role $role): string {
                    return $role->getDescription();
                },
                $normalizedRoles
            );
            $question = new ChoiceQuestion(
                '<question>Enter the ideal Role code of the team member (Default Point Guard):</question>',
                $roleDescriptions,
                $this->roleQueries->getDefaultIdealRole()->getCode()
            );
            $question->setNormalizer(function (string $value): string {
                return $value ? strtoupper(trim($value)) : '';
            });
            $question->setErrorMessage('Role %s is invalid.');
            $selectedRoleCode = $helper->ask($input, $output, $question);
            return $normalizedRoles[$selectedRoleCode];
        }

        private function askTeamMemberName(InputInterface $input, OutputInterface $output, $helper): string {
            $question = new Question('<question>Enter Team member name: </question>');
            $question->setNormalizer(function (?string $value): ?string {
                return $value ? ucwords(trim($value)) : null;
            });
            $question->setValidator(function ($answer) {
                if (is_null($answer)) {
                    throw new \RuntimeException('The team member name is required.');
                }

                return $answer;
            });
            $question->setMaxAttempts(2);
            $name = $helper->ask($input, $output, $question);
            return $name;
        }

        private function askCoachScore(InputInterface $input, OutputInterface $output, $helper): int {
            $question = new Question('<question>Enter the coach score (between 0 and 100):</question>');
            $question->setValidator(function ($answer) {
                if (is_null($answer)) {
                    throw new \RuntimeException('Coach score is required');
                }
                if (!is_numeric($answer)) {
                    throw new \RuntimeException('Coach score should be a number');
                }
                return $answer;
            });
            $coachScore = intval($helper->ask($input, $output, $question));
            return $coachScore;
        }
    }