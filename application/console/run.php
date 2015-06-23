<?php
/**
 * Console Config File
 */
include 'config.php';

/**
 * Init
 * Arquivo de iniciação WeConsole
 */
include 'core/init/init.php';

/**
 * Autoload file
 */
include 'core/vendor/autoload.php';

/**
 * Start application
 */

use \comands\repository\Repository;
use \comands\controller\Controller;
use \comands\view\View;
use \comands\model\Model;
use \comands\mvc\Mvc;
use \Symfony\Component\Console\Application;

$application = new Application();
$application->add(new Repository());
$application->add(new Controller());
$application->add(new Model());
$application->add(new View());
$application->add(new Mvc());
$application->run();