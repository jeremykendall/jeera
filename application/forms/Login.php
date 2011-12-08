<?php

/**
 * Generic login form
 *
 * @category    Jeera
 * @package     Jeera_Form
 */

/**
 * @category    Jeera
 * @package     Jeera_Form
 */
class Jeera_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'username', array(
            'required' => true,
            'label' => 'Username'
        ));

        $this->addElement('password', 'password', array(
            'required' => true,
            'label' => 'Password'
        ));

        $this->addElement('submit', 'submit', array(
            'label' => 'Submit',
            'ignore' => true
        ));

        $this->setElementFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_StripTags()
        ));

    }
}

