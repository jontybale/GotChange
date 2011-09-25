<?php

/** @see \Zend_Application */
require_once 'Zend/Application.php';

/** @see \Zend_Text_PHPUnit_ControllerTestCase */
require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

/** @see \PHPUnit_Framework_TestCase */
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * abstract class for controller test cases
 */
abstract class ControllerTestCase extends \Zend_Test_PHPUnit_ControllerTestCase
{
    /**
     * setUp function to ensuer that we have a valid application
     * state before every request
     */
    protected function setUp()
    {
        // bootstrap
        $this->bootstrap =  new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );
        parent::setUp ();
    }

    /**
     * tearDown function to ensure that we return the application to the default
     * state after every request
     */
    protected function tearDown()
    {
        \Zend_Controller_Front::getInstance()->resetInstance();

        $this->resetRequest();
        $this->resetResponse();

        $this->request->setPost(array());
        $this->request->setQuery(array());
    }
}