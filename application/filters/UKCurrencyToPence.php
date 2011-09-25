<?php

/** @see \Zend_Filter_Interface */
require_once 'Zend/Filter/Interface.php';

/**
 * Class which implements a filter to convert a valid UK currency in to its value
 * in pence.
 *
 * @package GotChange
 * @author jontybale
 */
class GotChange_Filter_UKCurrencyToPence implements \Zend_Filter_Interface
{
    
    /**
     * method to filter a valid UK currency string, and normalise it in to a
     * pence value.
     * 
     * @param string $value
     * @return float in case we run in to issues with > 32 bits values.
     */
    public function filter($value)
    {
        // cast to string
        $valueString = (string) $value;
        // remove characters other than Â£,p,.,0-9
        $valueString = preg_replace("/[^Â£0-9\.p]/u", "", $valueString);
        // is this a value in pence?
        if (preg_match("/^[0-9]+p?$/u", $valueString)) {
            // remove alpha and cast to float
            $value = (float) preg_replace("/p/", "", $valueString);
        } else {
            // otherwise a value in pounds, remove all non numeric/period
            $valuePounds = (float) preg_replace("/[^0-9\.]/", "", $valueString);
            // convert to pence
            $value = $valuePounds * 100;
        }
        // and return value making sure it is rounded to 0 dp
        return round($value);
    }
    
}