<?php
/**
 * Playface Core
 *
 * @package Playface
 * @author jontyb
 */

/** @see Zend_Application_Bootstrap_Bootstrap */
require_once 'Zend/Application/Bootstrap/Bootstrap.php';

/**
 * boostrap for our main application
 *
 * @author jontyb
 * @package GotChange
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected $_appNamespace = "GotChange";

    /**
     * autoloader
     */
    protected function _initAutoloader()
    {
        // add any custom resource types
        $this->_resourceLoader->addResourceType('filter', 'filters', 'Filter')
                              ->addResourceType('validate', 'validators', 'Validate');
    }

    /**
     * load config information in to registry
     */
    protected function _initRegistry()
    {
        // load basic system settings
        Zend_Registry::set('tmpdir', $this->_options['default']['system']['tmpdir']);
        Zend_Registry::set('salt', $this->_options['default']['system']['salt']);
    }
    
    /**
     * prepare logging
     */
    protected function _initLog()
    {
        if ($this->hasPluginResource("log")) {
            $r = $this->getPluginResource("log");
            $log = $r->getLog();
            Zend_Registry::set('log',$log);
        }
    }
}