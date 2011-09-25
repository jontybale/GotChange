<?php

/**
 * ErrorController
 * 
 * @author jontybale
 * @package GotChange
 * @see \Zend_Controller_Action
 */
class ErrorController extends \Zend_Controller_Action
{
    /**
     * render and display errors
     */
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

        // switch based on our error type
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                $this->view->headTitle('Page Not Found');
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                $this->view->headTitle('Application Error');
                // log error
                \Zend_Registry::get('log')->log(
                        $this->view->message . "\t" . $errors->exception->getMessage() . "\t" . $this->_request->getRequestUri(),
                        \Zend_Log::ERR
                );
                break;
        }

        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }

        // copy request information in to the view
        $this->view->request = $errors->request;

        // now make sure we show the error layout
        $this->_helper->layout->setLayout('error');
    }

}