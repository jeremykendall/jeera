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
    
    /**
     * Translator for form error messages
     * 
     * Using Zend_Translate makes it dead easy to customize error messages.  See
     * {@link http://framework.zend.com/manual/en/zend.form.i18n.html}
     * 
     * @var Zend_Translate
     */
    private $_translator;

    public function init()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        $this->_db = $bootstrap->getResource('db');
        $this->_translator = $bootstrap->getResource('translator');
    }

    /**
     * Displays a list of submitted tickets and link to submit new tickets
     */
    public function indexAction()
    {
        $tickets = new Jeera_Service_Tickets($this->_db);
        $this->view->tickets = $tickets->fetchAll();
    }

    /**
     * Ticket detail view
     */
    public function viewAction()
    {
        $identity = Zend_Auth::getInstance()->getIdentity();
        $this->view->isAdminUser = ($identity['userRole'] == 'admin') ? true : false;

        $ticketId = (int) $this->getRequest()->getParam('ticket');

        if ($ticketId) {
            $tickets = new Jeera_Service_Tickets($this->_db);
            $ticket = $tickets->find($ticketId);
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
        $form->setTranslator($this->_translator);
        $form->getElement('impact')
            ->setMultiOptions(array('Select Impact') + $this->_impactOptions)
            ->setValidators(array(new Zend_Validate_InArray($this->_impactOptions)));
        $this->view->form = $form;

        $request = $this->getRequest();

        if (!$request->isPost() || !$form->isValid($request->getPost())) {
            return;
        }

        $data = $form->getValues();
        $data['createdBy'] = $user['userId'];
        $data['lastUpdatedBy'] = $user['userId'];

        $table = new Jeera_Model_DbTable_Tickets();
        $table->insert($data);
        $ticketId = $table->getAdapter()->lastInsertId();

        // TODO use different redirector so path isn't so brittle
        return $this->_redirect('/tickets/view/ticket/' . $ticketId);
    }

    /**
     * Modify ticket
     */
    public function modifyAction()
    {
        // TODO Need to refactor the form and how I'm populating values in the form
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

        $form = new Jeera_Form_EditTicket();
        $form->setTranslator($this->_translator);
        $form->getElement('status')->setMultiOptions($this->_statusOptions);
        $form->getElement('impact')->setMultiOptions($this->_impactOptions);
        $form->getElement('assignedTo')
            ->setMultiOptions(array('Select assignee') + $adminUsers)
            ->setValidators(array(new Zend_Validate_InArray(array_keys($adminUsers))));
        
        $form->populate($ticket);

        $this->view->form = $form;

        $request = $this->getRequest();

        if (!$request->isPost() || !$form->isValid($request->getPost())) {
            return;
        }

        $data = $form->getValues();
        $data['lastUpdatedBy'] = $user['userId'];

        $ticketsTable->update($data, "ticketId = $ticketId");

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
        $form->setTranslator($this->_translator);
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
