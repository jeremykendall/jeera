<?php
/**
 * Jeera Trouble Ticket System
 *
 * @category    Jeera
 * @package     Jeera_Form
 */

/**
 * Jeera Form superclass
 *
 * @category    Jeera
 * @package     Jeera_Form
 */
class Jeera_Form extends Zend_Form
{

    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->removeHiddenElementDecorators();
    }

    /**
     * Removes decorators from hidden elements.  Last function called by constructor
     */
    public function removeHiddenElementDecorators()
    {
        $elements = $this->getElements();

        foreach ($elements as $element) {
            if ($element->getType() == 'Zend_Form_Element_Hidden') {
                $element->clearDecorators();
            }
        }
    }
}