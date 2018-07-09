<?php

    namespace ManagerAdvisor\Command;

    use ManagerAdvisor\Command\Questions\UniformNumberQuestion;
    use ManagerAdvisor\Domain\Role;
    use ManagerAdvisor\Domain\TeamMember;
    use ManagerAdvisor\Injector\Injector;
    use ManagerAdvisor\Query\GetDefaultIdealRole;
    use ManagerAdvisor\Query\GetNormalizedRoles;
    use ManagerAdvisor\usecase\AddTeamMember;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Question\ChoiceQuestion;
    use Symfony\Component\Console\Question\Question;

    class AddTeamMemberCommand extends Command {
        const UNIFORM_NUMBER = 'uniformNumber';
        const NAME = 'name';
        const ENTER_UNIFORM_NUMBER = 'Enter uniform number';

        /**
         * @var GetNormalizedRoles
         */
        private $getNormalizedRoles;

        /**
         * @var GetDefaultIdealRole
         */
        private $getDefaultIdealRole;

        /**
         * @var AddTeamMember
         */
        private $addTeamMember;

        /**
         * @var UniformNumberQuestion
         */
        private $uniformNumberQuestion;

        public function __construct(Injector $injector) {
            parent::__construct();
            $this->getNormalizedRoles = $injector->getGetNormalizedRoles();
            $this->getDefaultIdealRole = $injector->getGetDefaultIdealRole();
            $this->addTeamMember = $injector->getAddTeamMember();
            $this->uniformNumberQuestion = new UniformNumberQuestion(self::ENTER_UNIFORM_NUMBER);
        }

        protected function configure() {
            $this
                ->setName('addTeamMember')
                ->setDescription('Add a new team member')
                ->setHelp('This command adds a new member to the team');
        }

        protected function execute(InputInterface $input, OutputInterface $output) {
            $helper = $this->getHelper('question');

            $uniformNumber = $this->uniformNumberQuestion->ask($input, $output, $helper);
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

        private function askIdealRole(InputInterface $input, OutputInterface $output, $helper): Role {
            $normalizedRoles = $this->getNormalizedRoles->execute();
            $roleDescriptions = array_map(
                function (Role $role): string {
                    return $role->getDescription();
                },
                $normalizedRoles
            );
            $question = new ChoiceQuestion(
                '<question>Enter the ideal Role code of the team member (Default Point Guard):</question>',
                $roleDescriptions,
                $this->getDefaultIdealRole->execute()->getCode()
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