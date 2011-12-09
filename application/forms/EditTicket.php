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
class Jeera_Form_EditTicket extends Zend_Form
{

    /**
     * @var array List of all application admin users
     */
    private $_adminUsers;

    /**
     * Create new Jeera_Form_EditTicket form
     *
     * @param array $adminUsers List of all application admin users
     * @param mixed $options
     */
    public function __construct(array $adminUsers, $options = null)
    {
        $this->_adminUsers = $adminUsers;
        parent::__construct($options);
    }

    public function init()
    {
        $this->addElement('hidden', 'createdBy', array(
            'validators' => array('Int'),
            'filters' => array('Int'),
        ));

        $this->addElement('hidden', 'lastUpdatedBy', array(
            'validators' => array('Int'),
            'filters' => array('Int'),
        ));

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
            'multiOptions' => $statusOptions,
            'required' => true,
            'label' => 'Status'
        ));

        $impactOptions = array(
            'critical' => 'critical',
            'moderate' => 'moderate',
            'minor' => 'minor'
        );

        $this->addElement('select', 'impact', array(
            'multiOptions' => array_merge(array('Select impact'), $impactOptions),
            'validators' => array(
                array('InArray', false, array($impactOptions))
            ),
            'required' => true,
            'label' => 'Impact'
        ));

        $this->addElement('select', 'assignedTo', array(
            'multiOptions' => array('Select assignee') + $this->_adminUsers,
            'validators' => array(
                array('InArray', false, array(array_keys($this->_adminUsers)))
            ),
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
