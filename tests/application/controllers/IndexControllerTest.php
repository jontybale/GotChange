<?php

/** @see ControllerTestCase */
require_once 'ControllerTestCase.php';

/** @see IndexController */
require_once APPLICATION_PATH . '/controllers/IndexController.php';

/**
 * Test class for IndexController.
 * Generated by PHPUnit on 2011-09-25 at 16:39:44.
 */
class IndexControllerTest extends ControllerTestCase
{
    
    /**
     * basic get request to the index page & ensure we have the form
     */
    public function testIndexAction()
    {
        // make request
        $this->dispatch('/');
        
        // validate response is correct
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertResponseCode(200);
        
        // check that we have our input form
        $this->assertQueryCount('form#gotchange-form-input', 1);
        $this->assertQueryCount('input#change', 1);
    }
    
    /**
     * test a valid form submission
     */
    public function testIndexPostValidForm()
    {
        // setup request
        $this->request->setMethod('POST');
        $this->request->setPost(array('change' => '20p'));
        
        // make request
        $this->dispatch('/');
        
        // handle our response
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertResponseCode(200);
        
        // validate our result
        $this->assertQueryCount('span.coinqty span.type', 1);
        $this->assertQueryContentContains('span.coinqty span.type', '20p');
        $this->assertQueryCount('span.coinqty span.value', 1);
        $this->assertQueryContentContains('span.coinqty span.value', '1');
    }
    
    /**
     * test an ajax request which succeeds
     */
    public function testIndexPostValidFormViaAjax()
    {
        // setup request
        $this->request->setMethod('POST');
        $this->request->setPost(array('change' => '£1.52'));
        
        // setup expected json response
        $expected = array(
            '100' => 1,
            '50' => 1,
            '2' => 1
        );
        
        // make request
        $this->dispatch('/index/index/format/json');
        
        // handle our response
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertResponseCode(200);
        
        // get our change from the response and compare
        $body = json_decode($this->response->getBody());
        $actual = array();
        foreach($body->change AS $key => $value) {
            $actual[$key] = $value;
        }
        $this->assertEquals($expected, $actual);
                
    }
    
    /**
     * test an ajax request which fails
     */
    public function testIndexPostBadFormViaAjax()
    {
        // setup request
        $this->request->setMethod('POST');
        $this->request->setPost(array('change' => '£1.5x2'));
        
        // setup expected json response for errors
        $expected = array('msgUKCurrencyInvalid');
        
        // make request
        $this->dispatch('/index/index/format/json');
        
        // handle our response
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertResponseCode(200);
        
        // get our change element should have an error with an an invalid format
        // error from the UKCurrency validator
        $body = json_decode($this->response->getBody());
        $actual = array();
        foreach($body->formErrors->change AS $value) {
            $actual[] = $value;
        }
        $this->assertEquals($expected, $actual);
                
    }
}