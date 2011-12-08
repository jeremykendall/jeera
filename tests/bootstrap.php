<?php

error_reporting(-1);
date_default_timezone_set('America/Chicago');

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
define('APPLICATION_ENV', 'testing');

// Ensure library/ is on include_path
set_include_path(
    implode(
        PATH_SEPARATOR, array(
        realpath(APPLICATION_PATH . '/../library'),
        get_include_path(),
        )
    )
);

require_once 'application/ControllerTestCase.php';

/** Zend_Application */
require_once 'Zend/Application.php';

//$application = new Zend_Application(
//        APPLICATION_ENV,
//        APPLICATION_PATH . '/configs/application.ini'
//);
//
//$application->bootstrap();

/**
 * shorthand debug functions via Jaybill
 * http://jaybill.com/2007/10/01/the-most-useful-function-you-will-ever-use-in-the-zend-framework/
 * Modified by Jeremy Kendall
 */
function d($val, $label="", $echo=true)
{
    Zend_Debug::dump($val, $label, $echo);
}

function dd($val, $label="", $echo=true)
{
    d($val, $label, $echo);
    die();
}
