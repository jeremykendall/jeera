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

    /**
     * @var Zend_Db_Adapter_Abstract
     */
    private $_db;
    /**
     *  Ticket status options
     *
     * @var array
     */
    private $_statusOptions = array(
        'new' => 'new',
        'in-progress' => 'in-progress',
        'complete' => 'complete'
    );
    /**
     * Ticket impact options
     *
     * @var array
     */
    private $_impactOptions = array(
        'critical' => 'critical',
        'moderate' => 'moderate',
        'minor' => 'minor'
    );

    public function init()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        $this->_db = $bootstrap->getResource('db');
    }

    /**
     * Will display list of submitted tickets and link to submit new tickets
     */
    public function indexAction()
    {
        $table = new Jeera_Model_DbTable_Tickets();
        $this->view->tickets = $table->fetchAll();
    }

    /**
     * Ticket detail view
     */
    public function viewAction()
    {
        $identity = Zend_Auth::getInstance()->getIdentity();
        // Used in view logic
        $this->view->isAdminUser = ($identity['userRole'] == 'admin') ? true : false;

        $ticketId = (int) $this->getRequest()->getParam('ticket');

        if ($ticketId) {
            $sql = 'SELECT t.*, a.username AS assignedTo, c.username AS createdBy, up.username AS lastUpdatedBy '
                . 'FROM tickets AS t '
                . 'JOIN users AS a '
                . 'ON t.assignedTo = a.userId '
                . 'JOIN users AS c '
                . 'ON t.createdBy = c.userId '
                . 'JOIN users AS up '
                . 'ON t.lastUpdatedBy = up.userId '
                . 'WHERE ticketId = ?';
            $ticket = $this->_db->query($sql, array($ticketId))->fetch();
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
        $ticketId = (int) $this->getRequest()->getParam('ticket');
        $ticketsTable = new Jeera_Model_DbTable_Tickets();
        $ticket = $ticketsTable->find($ticketId);

        if (count($ticket) == 0) {
            $this->view->ticketNotFound = 'The ticket you requested could not be found.  Please try again.';
            return;
        }

        $ticket = $ticket->current()->toArray();

        $user = Zend_Auth::getInstance()->getIdentity();
        $usersTable = new Jeera_Model_DbTable_Users();
        $adminUsers = $usersTable->findAdminsMultiOptions();

        $createdBy = $usersTable->find($ticket['createdBy'])->current()->toArray();
        $ticket['createdByUsername'] = $createdBy['username'];
        $this->view->ticket = $ticket;

        $form = new Jeera_Form_EditTicket($adminUsers);
        $form->populate($ticket);
        $this->view->form = $form;

        $request = $this->getRequest();

        if (!$request->isPost() || !$form->isValid($request->getPost())) {
            return;
        }

        $ticketsTable->update($form->getValues(), "ticketId = $ticketId");

        return $this->_redirect('/tickets/view/ticket/' . $ticketId);
    }

    /**
     * Search tickets
     */
    public function searchAction()
    {
        $user = Zend_Auth::getInstance()->getIdentity();
        $usersTable = new Jeera_Model_DbTable_Users();
        $adminUsers = $usersTable->findAdminsMultiOptions();
        $allUsers = $usersTable->findUsersMultiOptions();

        $form = new Jeera_Form_SearchTickets();
        $form->getElement('impact')->setMultiOptions(array_merge(array('Any impact'), $this->_impactOptions));
        $form->getElement('status')->setMultiOptions(array_merge(array('Any status'), $this->_statusOptions));
        $form->getElement('assignedTo')->setMultiOptions(array('Any assignee') + $adminUsers);
        $form->getElement('createdBy')->setMultiOptions(array('Any assignee') + $allUsers);
        $form->getElement('lastUpdatedBy')->setMultiOptions(array('Any assignee') + $adminUsers);
        $this->view->form = $form;

        $request = $this->getRequest();

        if (!$request->isPost() || !$form->isValid($request->getPost())) {
            return;
        }

        $service = new Jeera_Service_Tickets($this->_db);
        $this->view->searchResults = $service->search($form->getValues());
    }

}
