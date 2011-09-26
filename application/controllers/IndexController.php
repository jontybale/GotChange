<?php

/**
 * IndexController
 *
 * @author jontybale
 * @package GotChange
 * @see \Zend_Controller_Action
 */
class IndexController extends \Zend_Controller_Action
{
    /**
     * setup context switch to handle form using json
     */
    public function init()
    {
        // get context switch helper
        $contextSwitch = $this->_helper->contextSwitch();
        // now add our action switch for index
        $contextSwitch->addActionContexts(array('index' => array('json')))
                      ->initContext();
    }
    
    /**
     * Show and/or process the input form.  May process normally and display
     * results or return json upon recipt of an ajax request.
     */
    public function indexAction()
    {
        $form = new \GotChange_Form_Input();
        // do we have a post of some data?
        if($this->_request->isPost()) {
            // do we have a valid form?
            if($form->isValid($this->_request->getPost())) {
                // get our pence value from the form
                $pence = $form->getPence();
                // load our cash register setting our avaliable coins
                // @todo JEB confirm if the lack of 10p and 5p coins is correct.
                $cashRegister = new \GotChange_Model_CashRegister(array(
                    200,100,50,20,2,1
                ));
                // calculate our change
                $change = $cashRegister->calculateChange($pence);
                // otherwise show completed result
                $this->view->assign('change', $change);
            } else {
                // make sure errors are avaliable in view
                $this->view->assign('formErrors', $form->getErrors());
            }
            // otherwise proceed to render view
        }
        // assign our form to the view
        $this->view->assign('form', $form);
    }
}