<?php

/** @see \GotChange_Form_Abstract */
require_once 'Abstract.php';

/**
 * Our basic form object for processing input of the value we want to break down
 * in to indervidual coins.
 *
 * @author jontybale
 * @package GotChange
 */
class GotChange_Form_Input extends \GotChange_Form_Abstract
{
    /**
     * initalise our form and assign elements
     */
    public function init()
    {
        // setup form
        $this->setMethod(\Zend_Form::METHOD_POST)
             ->setOptions(array('id' => 'gotchange-form-input'));
        
        // add our elements
        $this->addElements(array(
            $this->createElement('text', 'change'),
            $this->createElement('button', 'submitbutton')
        ));
        
        // modify input
        // not including filter here as we do not want to mess with user input
        // (converting pounds > pence could be confusing)
        $this->getElement('change')
             ->setLabel('Enter the amount of change you want coins for')
             ->setDescription('Enter here the value in sterling or pence you wish to calculate coinage for.')
             ->setRequired(true)
             ->setOptions(array('class' => 'required', 'tabindex' => 1, 'maxlength' => 8))
             ->setDecorators($this->_elementDecorators)
             ->addValidator(new \GotChange_Validate_UKCurrency());
        
        // modify submit button
        $this->getElement('submitbutton')
             ->setLabel('Calculate')
             ->setOptions(array('type' => 'submit', 'tabindex' => 2))
             ->setDecorators($this->_buttonDecorators)
             ->getDecorator('row')->setOption('class', 'row last');
    }
    
    /**
     * retreive our value in pence from the change using our UKCurrencyToPence
     * filter.
     * @return float
     */
    public function getPence()
    {
        $penceFilter = new \GotChange_Filter_UKCurrencyToPence();
        return $penceFilter->filter($this->getValue('change'));
    }
}