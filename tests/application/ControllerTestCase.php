<?php

require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

/**
 * Description of ControllerTestCase
 *
 * @category
 * @package
 * @subpackage
 * @version     $Id$
 */

/**
 * @category
 * @package
 * @subpackage
 */
class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{

    /**
     * @var Zend_Application
     */
    protected $application;

    public function setUp()
    {

        $this->bootstrap = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
        );

        parent::setUp();
    }

}
