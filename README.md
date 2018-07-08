# PHP basketball manager advisor

## Setup

To install the project:

    php composer.phar create-project carloscasalar/basketball-manager-advisor [path] *

You will have an empty ``src/`` directory and a ``phpunit.xml.dist`` that is configured to run all the PHPUnit tests
names ``*Test.php`` in the directories ``src/*/Tests`` (and their subdirectories). When you use this configuration the
Composer autoloader will be initialized automatically to make sure that every namespaced class inside ``src/`` can be
auto-loaded from within the test cases.

### Alternate install

If you don't want to install php in your system you can install this project with this command:

    docker run --rm -v /YOUR/LOCAL/PROJECTS/DIR:/opt -w /opt shippingdocker/php-composer:latest composer create-project carloscasalar/basketball-manager-advisor basketball-manager-advisor
    
Where `/YOUR/LOCAL/PROJECTS/DIR` is the local folder where this project will be installed.    

### Configure PHPStorm to run the tests

- Choose ``Run``, ``Edit configurations...`` and remove any existing configuration.
- Select ``Defaults - PHPUnit``, put a check before ``Use alternative configuration file`` and select
  ``phpunit.xml.dist`` from this project.
- Click the button to the right of this field. In the dialog that appears select ``Use custom loader`` and select the
  file ``vendor/autoload.php`` inside your project. This will make sure PHPStorm uses the bundled version of PHPUnit.

To validate your setup once you have installed this project, run the tests: right-click on the ``src/`` directory and
then select ``Run 'src'``.

## Run the unit tests

You can run the tests from the command-line:

    php vendor/bin/phpunit

When you first run the tests, PHPStorm might ask you to supply a PHP interpreter.

Or you can run the test without install php with docker:
    
    docker run --rm -it -v /YOUR/LOCAL/PROJECTS/DIR/basketball-manager-advisor:/opt -w /opt shippingdocker/php-composer:latest composer run-script test 

To show a list of all tests being launched:    
    
    docker run --rm -it -v /YOUR/LOCAL/PROJECTS/DIR/basketball-manager-advisor:/opt -w /opt shippingdocker/php-composer:latest composer run-script test-checklist

## Run de app

You can run de app with the following command:

    php bin/console
    
Also with composer command `run`:
    
    composer run-script run
    
If you don't have php or composer installed in your system you can run it with docker

    docker run --rm -it -v /YOUR/LOCAL/PROJECTS/DIR/basketball-manager-advisor:/opt -w /opt shippingdocker/php-composer:latest php bin/console.php        
    docker run --rm -it -v /YOUR/LOCAL/PROJECTS/DIR/basketball-manager-advisor:/opt -w /opt shippingdocker/php-composer:latest composer run-script run        

## PHPUnit cheatsheet

You can use [matthiasnoback's](https://github.com/matthiasnoback) [PHPUnit cheatsheet](https://github.com/matthiasnoback/workshop-unit-testing/blob/master/cheatsheet.md)
as a quick reference for PHPUnit usage.

# About 

This project structure is based in [matthiasnoback/php-coding-dojo](https://github.com/matthiasnoback/php-coding-dojo).

Also thanks to [shipping-docker/php-composer](https://github.com/shipping-docker/php-composer) for sharing the docker commands.
