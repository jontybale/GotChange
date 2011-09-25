<?php

/**
 * Interface representing our logical till / cash register
 * @package GotChange_Model
 * @author jontybale
 */
interface GotChange_Model_Interface_ICashRegister
{
    public function __construct($coinValues);
    public function calculateChange($amount);
    public function getCoinValues();
}