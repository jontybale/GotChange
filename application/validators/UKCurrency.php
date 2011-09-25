<?php

/** @see \Zend_Validate_Abstract */
require_once 'Zend/Validate/Abstract.php';

/**
 * Class which implements a validation routine on a string to verify if it matches
 * a format which is a recognisable as UK currency.
 *
 * @package GotChange
 * @author jontybale
 */
class GotChange_Validate_UKCurrency extends \Zend_Validate_Abstract implements \Zend_Validate_Interface
{
    
    /**
     * error codes
     */
    const MSG_UKCURRENCY_INVALID    = 'msgUKCurrencyInvalid';
    const MSG_UKCURRENCY_FORMAT     = 'msgUKCurrencyFormat';
    
    /**
     * error messages
     * @var array
     */
    protected $_messageTemplates = array(
        self::MSG_UKCURRENCY_INVALID    => "The value contains characters that are not recognised as UK currency.",
        self::MSG_UKCURRENCY_FORMAT     => "Invalid UK currency format.",
    );
    
    /**
     * routine to test if the value is valid, must comply with the following:
     * 
     * First character may or may not be Â£.
     * Last character may or may not be p
     * Remainder must be a valid float, or integer.
     * 
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        // make sure we are dealing with a string & set value
        $valueString = (string) $value;
        $this->_setValue($valueString);
        // can contain only Â£,p,.,0-9 - dont forget /u as UTF-8
        if (preg_match("/[^£0-9\.p]/u", $this->_value)) {
            // add error and return false
            $this->_error(self::MSG_UKCURRENCY_INVALID);
            return false;
        }
        // now check the format - dont forget /u as UTF-8
        // @todo JEB investigate better regex for edge cases (leading/trailing dp)
        if (!preg_match("/^£?([0-9]+\.?[0-9]*|[0-9]*\.?[0-9]+)p?$/u", $this->_value)) {
            // add error and return false
            $this->_error(self::MSG_UKCURRENCY_FORMAT);
            return false;
        }
        // otherwise return TRUE
        return true;
    }
    
}