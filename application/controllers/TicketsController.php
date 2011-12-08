<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TicketController
 *
 * @category
 * @package
 * @subpackage
 * @version     $Id$
 */

/**
 * @category
 * @package
 * @subpackage
 */
class TicketsController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    /**
     * Will display list of submitted tickets and link to submit new
     */
    public function indexAction()
    {
        
    }

    /**
     * Ticket detail view
     */
    public function viewAction()
    {
        $ticketId = (int) $this->getRequest()->getParam('ticket');
        
        if ($ticketId) {
            $table = new Jeera_Model_DbTable_Tickets();
            $ticket = $table->find($ticketId);
            $this->view->ticket = $ticket;
        }
    }

    /**
     * Submit new ticket
     */
    public function submitAction()
    {
        $user = Zend_Auth::getInstance()->getIdentity();
        
        $form = new Jeera_Form_NewTicket();
        $form->getElement('createdBy')->setValue($user['userId']);
        $form->getElement('lastUpdatedBy')->setValue($user['userId']);
        $this->view->form = $form;
        
        $request = $this->getRequest();

        if (!$request->isPost() || !$form->isValid($request->getPost())) {
            return;
        }
        
        $table = new Jeera_Model_DbTable_Tickets();
        $table->insert($form->getValues());
        $ticketId = $table->getAdapter()->lastInsertId();
        
        // TODO use different redirector so path isn't so brittle
        return $this->_redirect('/tickets/view/ticket/' . $ticketId);
    }

    /**
     * Modify ticket
     */
    public function modifyAction()
    {
        
    }

    /**
     * Search tickets
     */
    public function searchAction()
    {
        
    }

}
