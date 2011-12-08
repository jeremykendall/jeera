<?php

class IndexController extends Zend_Controller_Action
{

    /**
     * Redirect all traffic to /tickets/
     */
    public function indexAction()
    {
        return $this->_helper->redirector('index', 'tickets');
    }

}

