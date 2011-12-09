<?php

/**
 * Jeera Trouble Ticket System
 *
 * @category    Jeera
 * @package     Jeera_Form
 */

/**
 * Edit trouble ticket form
 *
 * @category    Jeera
 * @package     Jeera_Form
 */
class Jeera_Form_EditTicket extends Jeera_Form
{

    public function init()
    {

        $this->addElement('text', 'problemType', array(
            'required' => true,
            'label' => 'Problem Type'
        ));

        $this->addElement('textarea', 'problemDescription', array(
            'required' => true,
            'label' => 'Problem Description',
            'cols' => 40,
            'rows' => 3,
        ));

        $statusOptions = array(
            'new' => 'new',
            'in-progress' => 'in-progress',
            'complete' => 'complete'
        );

        $this->addElement('select', 'status', array(
            'required' => true,
            'label' => 'Status'
        ));

        $impactOptions = array(
            'critical' => 'critical',
            'moderate' => 'moderate',
            'minor' => 'minor'
        );

        $this->addElement('select', 'impact', array(
            'required' => true,
            'label' => 'Impact'
        ));

        $this->addElement('select', 'assignedTo', array(
            'required' => true,
            'label' => 'Assign To'
        ));

        $this->addElement('textarea', 'notes', array(
            'required' => true,
            'label' => 'Notes',
            'cols' => 40,
            'rows' => 3,
        ));

        $this->addElement('submit', 'submit', array(
            'label' => 'Submit',
            'ignore' => true,
            'order' => 1000
        ));

        $this->setElementFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_StripTags()
        ));
    }

}
