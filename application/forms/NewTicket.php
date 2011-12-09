<?php

/**
 * Jeera Trouble Ticket System
 *
 * @category    Jeera
 * @package     Jeera_Form
 */

/**
 * New trouble ticket form
 *
 * @category    Jeera
 * @package     Jeera_Form
 */
class Jeera_Form_NewTicket extends Jeera_Form
{

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
