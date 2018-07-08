<?php
    namespace ManagerAdvisor\Command\Questions;


    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Question\Question;

    class UniformNumberQuestion {
        private $question;

        public function __construct(string $question) {
            $this->question = $question;
        }

        public function ask(InputInterface $input, OutputInterface $output, $helper): int {
            $question = new Question('<question>'.$this->question.': </question>');
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
    }