<?php

/**
 * base form for the GotChange application, contains our base decorators
 *
 * @author jontybale
 * @package GotChange
 * @see \Zend_Form
 */
class GotChange_Form_Abstract extends \Zend_Form
{
    /**
     * element decorator
     * @var array
     */
    protected $_elementDecorators = array(
        array('ViewHelper'),
        array('Errors'),
        array(array('InputCell' => 'HtmlTag'), array('tag' => 'div', 'class' => 'input cell')),
        array(array('LabelOpen' => 'HtmlTag'), array('tag' => 'div', 'closeOnly' => true, 'placement' => 'PREPEND')),
        array('Label', array('placement' => 'PREPEND')),
        array(array('LabelClose' => 'HtmlTag'), array('tag' => 'div', 'class' => 'label cell', 'openOnly' => true, 'placement' => 'PREPEND')),
        array('Description',array('tag' => 'div','class' => 'description cell','placement' => 'APPEND')),
        array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'row'))
    );
    
    /**
     * button decorator
     * @var array
     */
    protected $_buttonDecorators = array(
        array(array('LabelSpacer' => 'HtmlTag'), array('tag' => 'div', 'class' => 'cell button')),
        array('ViewHelper'),
        array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'row'))
    );
    
    /**
     * set our default form decorators
     */
    public function loadDefaultDecorators()
    {
        $this->setDecorators(
            array(
                'FormElements',
                array('Form', array('class' => 'gotchange-form')),
                array('HtmlTag', array('tag' => 'div', 'class' => 'form'))
            )
        );
    }
}