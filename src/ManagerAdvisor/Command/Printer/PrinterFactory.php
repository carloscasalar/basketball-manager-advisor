<?php

    namespace ManagerAdvisor\Command\Printer;

    use ManagerAdvisor\Command\View\FormatOptions;
    use Symfony\Component\Console\Output\OutputInterface;

    class PrinterFactory {

        /**
         * @var OutputInterface
         */
        private $output;

        private $printerInstantiators;

        public function __construct(OutputInterface $output) {
            $this->output = $output;

            $this->printerInstantiators = [
                FormatOptions::TABLE => array($this, 'instantiateTeamMemberListTablePrinter'),
                FormatOptions::JSON => array($this, 'instantiateTeamMemberListJsonPrinter')
            ];
        }

        public function getPrinter($format): PrinterInterface {
            $instantiatePrinterCallback = $this->printerInstantiators[$format];
            return $instantiatePrinterCallback();
        }

        private function instantiateTeamMemberListTablePrinter(): PrinterInterface {
            return new TeamMemberListTablePrinter($this->output);
        }

        private function instantiateTeamMemberListJsonPrinter(): PrinterInterface {
            return new TeamMemberListJsonPrinter($this->output);
        }
    }