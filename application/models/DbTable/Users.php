<?php

/**
 * Table Data Gateway access for Users table
 *
 * @category    Jeera
 * @package     Jeera_Model
 * @subpackage  DbTable
 */

/**
 * @category    Jeera
 * @package     Jeera_Model
 * @subpackage  DbTable
 */
class Jeera_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
    protected $_primary = 'userId';

    /**
     * Retrieves user row as array
     * 
     * @param string $username
     * @return Zend_Db_Table_Row_Abstract|null
     */
    public function findByUsername($username)
    {
        $select = $this->select()->where('username = ?', $username);
        return $this->fetchRow($select);
    }
}