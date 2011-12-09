<?php

/**
 * Jeera Trouble Ticket System
 *
 * @category    Jeera
 * @package     Jeera_Form
 */

/**
 * Search form
 *
 * @category    Jeera
 * @package     Jeera_Form
 */
class Jeera_Form_SearchTickets extends Jeera_Form
{

    public function init()
    {

        $this->addElement('text', 'ticketId', array(
            'label' => 'Ticket Id',
            'validators' => array('Int')
        ));

        $this->addElement('text', 'textSearch', array(
            'label' => 'Search text'
        ));

        $this->addElement('select', 'status', array(
            'label' => 'Status'
        ));

        $this->addElement('select', 'impact', array(
            'label' => 'Impact'
        ));

        $this->addElement('select', 'createdBy', array(
            'label' => 'Created By'
        ));

        $this->addElement('text', 'createdAfter', array(
            'label' => 'Created After'
        ));

        $this->addElement('text', 'createdBefore', array(
            'label' => 'Created Before'
        ));

        $this->addElement('select', 'assignedTo', array(
            'label' => 'Assigned To'
        ));

        $this->addElement('select', 'lastUpdatedBy', array(
            'label' => 'Last Updated By'
        ));

        $this->addElement('text', 'updatedAfter', array(
            'label' => 'Updated After'
        ));

        $this->addElement('text', 'updatedBefore', array(
            'label' => 'Updated Before'
        ));

        $this->addElement('submit', 'submit', array(
            'label' => 'Search',
            'ignore' => true,
            'order' => 1000
        ));

        $this->setElementFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_StripTags()
        ));
    }

}
