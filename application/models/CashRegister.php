<?php

/** @see GotChange_Model_Interface_ICashRegister */
require_once 'Interface/ICashRegister.php';

/** @see GotChange_Model_Exception */
require_once 'Exception.php';

/**
 * A class representing a "cash register".
 *
 * @author Jonty
 * @package GotChange_Model
 */
class GotChange_Model_CashRegister implements \GotChange_Model_Interface_ICashRegister
{
    /**
     * our reference array of avaliable coin values
     * @var array
     */
    protected $_coinValues = array();
    
    /**
     * constructor, taking an array of the values of coins we have in the register
     * @param array $coinValues 
     */
    public function __construct($coinValues)
    {
        // assign coin values ensuring we have integer value for each
        foreach ($coinValues AS $coinValue) {
            if (!is_int($coinValue)) {
                throw new \InvalidArgumentException(
                        'Unable to use a non-integer coin value.'
                );
            }
            $this->_coinValues[$coinValue] = $coinValue;
        }
        //sort in value order, highest to lowest
        rsort($this->_coinValues);
    }
    
    /**
     * method to calculate the amount of coins required to give a defined amount
     * of change.
     * @param mixed $amount
     * @return array
     */
    public function calculateChange($amount)
    {
        // ensure param is numeric
        if (!is_numeric($amount)) {
            throw new \InvalidArgumentException(
                    'Unable to calculate change for a non-numeric value.'
            );
        }
        // create our output array
        $change = array();
        // itterate though coin values
        foreach ($this->_coinValues AS $coinValue) {
            // how many coins do we have in the change?
            $coinQty = floor($amount / $coinValue);
            // do we have any coins?
            if ($coinQty > 0) {
                // we have coins, adjust amount
                $amount = $amount % $coinValue;
                // and store in our change array
                $change[$coinValue] = $coinQty;
            }
        }
        // do we have a remainder?
        if ($amount > 0) {
            // if so, throw an exception
            throw new \GotChange_Model_Exception(
                    'Unable to give exact change with the available coins.'
            );
        }
        // return our change
        return $change;
    }
    
    /**
     * get the current coin values
     * @return array
     */
    public function getCoinValues()
    {
        return $this->_coinValues;
    }
}
