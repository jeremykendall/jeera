<?php

/**
 * Jeera Trouble Ticket System
 *
 * @category    Jeera
 * @package     Jeera_Model
 * @subpackage  DbTable
 */

/**
 * Tickets database table
 * 
 * @category    Jeera
 * @package     Jeera_Model
 * @subpackage  DbTable
 */
class Jeera_Model_DbTable_Tickets extends Zend_Db_Table_Abstract
{

    private $_dateFormat = 'Y-m-d H:i:s';
    protected $_name = 'tickets';
    protected $_primary = 'ticketId';

    /**
     * Overrides Zend_Db_Table_Abstract::insert() to provide status,
     * lastUpdatedDate, and createdDate
     *
     * @param array $data 
     */
    public function insert(array $data)
    {
        $now = date($this->_dateFormat);
        $data['createdDate'] = $now;
        $data['lastUpdatedDate'] = $now;
        $data['status'] = 'new';
        parent::insert($data);
    }

    /**
     * Overrides Zend_Db_Table_Abstract::update() to provide lastUpdatedDate
     *
     * @param array $data 
     * @param array|string $where
     */
    public function update(array $data, $where)
    {
        $now = date($this->_dateFormat);
        $data['lastUpdatedDate'] = $now;
        parent::update($data, $where);
    }

}
