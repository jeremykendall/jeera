<?php
/**
 * Jeera Access Control List
 *
 * @category    Jeera
 * @package     Jeera_Acl
 */

/**
 * @category    Jeera
 * @package     Jeera_Acl
 */
class Jeera_Acl_Acl extends Zend_Acl
{
    /**
     * Public constructor
     */
    public function __construct()
    {
        $this->addRole(new Zend_Acl_Role('guest'));
        $this->addRole(new Zend_Acl_Role('user'), 'guest');
        $this->addRole(new Zend_Acl_Role('admin'));

        $this->add(new Zend_Acl_Resource('auth'));
        $this->add(new Zend_Acl_Resource('error'));
        $this->add(new Zend_Acl_Resource('index'));
        $this->add(new Zend_Acl_Resource('tickets'));

        $this->allow('guest', 'auth', array('index', 'login'));
        $this->allow('guest', 'error');
        $this->allow('guest', 'index');
        $this->deny('guest', 'tickets');

        $this->allow('user', 'auth', array('logout'));
        $this->deny('user', 'auth', array('login'));
        $this->allow('user', 'tickets', array('index', 'search', 'submit', 'view'));
        $this->deny('user', 'tickets', array('modify'));

        $this->allow('admin');
        $this->deny('admin', 'auth', array('login'));
    }
}
