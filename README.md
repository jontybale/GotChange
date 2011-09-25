# GotChange

**An example Zend Framework application.**

This is a simple application that given a number of pennies will calculate the minimum number of Sterling coins needed to make that amount.

> Eg. 123p = 1 x Â£1, 1 x 20p, 1 x 2p, 1 x 1p

## PEAR Requirements

This application requires PHP 5.3 and the following PEAR packages:

- **Zend Framework**
  pear channel-discover zend.googlecode.com/svn
  pear install --alldeps zend/zend
- **PHPUnit**
  pear channel-discover pear.phpunit.de
  pear install --alldeps phpunit/PHPUnit

The front end (including JavaScript/Jquery/CSS) is not implemented as I would like.