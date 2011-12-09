<?php

/**
 * Jeera Trouble Ticket System
 *
 * @category    Jeera
 * @package     Jeera_Model
 * @subpackage  DbTable
 */

/**
 * Users database table
 * 
 * @category    Jeera
 * @package     Jeera_Model
 * @subpackage  DbTable
 */
class Jeera_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
    protected $_primary = 'userId';

    /**
     * Retrieves user row
     * 
     * @param string $username
     * @return Zend_Db_Table_Row_Abstract|null
     */
    public function findByUsername($username)
    {
        $select = $this->select()->where('username = ?', $username);
        return $this->fetchRow($select);
    }

    /**
     * Gets array of admin users for use in form select elements
     * 
     * @return array 
     */
    public function findAdminsMultiOptions()
    {
        $select = $this->select()
            ->from($this, array('userId', 'username'))
            ->where('userRole = ?', 'admin')
            ->order('lastName');
        return $this->getAdapter()->fetchPairs($select);
    }

    /**
     * Gets array of all users for use in form select elements
     * 
     * @return array
     */
    public function findUsersMultiOptions()
    {
        $select = $this->select()
            ->from($this, array('userId', 'username'))
            ->order('lastName');
        return $this->getAdapter()->fetchPairs($select);
    }

}