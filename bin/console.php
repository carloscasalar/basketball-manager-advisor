#!/usr/bin/env php
<?php
    require __DIR__ . '/../vendor/autoload.php';

    use ManagerAdvisor\Injector\Injector;
    use Symfony\Component\Console\Application;
    use ManagerAdvisor\Command\AddTeamMemberCommand;

    $injector = new Injector();
    $application = new Application();

    $application->add(new AddTeamMemberCommand($injector));

    $application->run();