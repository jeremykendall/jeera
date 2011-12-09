<?php

/**
 * Jeera Trouble Ticket System
 *
 * @category    Jeera
 * @package     Jeera_Service
 */

/**
 * Ticket service
 *
 * @category    Jeera
 * @package     Jeera_Service
 */
class Jeera_Service_Tickets
{

    /**
     * @var Zend_Db_Adapter_Abstract
     */
    private $_db;

    /**
     * Public constructor
     *
     * @param Zend_Db_Adapter_Abstract $db
     */
    public function __construct(Zend_Db_Adapter_Abstract $db)
    {
        $this->_db = $db;
    }

    /**
     * Searches ticket database
     *
     * @param array $data
     * @return array Search results
     */
    public function search(array $data)
    {

        $sql = 'SELECT t.*, a.username AS assignedTo, c.username AS createdBy, up.username AS lastUpdatedBy '
            . 'FROM tickets AS t '
            . 'JOIN users AS a '
            . 'ON t.assignedTo = a.userId '
            . 'JOIN users AS c '
            . 'ON t.createdBy = c.userId '
            . 'JOIN users AS up '
            . 'ON t.lastUpdatedBy = up.userId ';

        $where = array();
        $params = array();

        if (strlen($data['ticketId']) >= 6) {
            $where[] = 't.ticketId = :ticketId';
            $params[':ticketId'] = $data['ticketId'];
        }

        if ($data['status'] != '0') {
            $where[] = 't.status = :status';
            $params[':status'] = $data['status'];
        }

        if ($data['createdBy'] != '0') {
            $where[] = 't.createdBy = :createdBy';
            $params[':createdBy'] = $data['createdBy'];
        }

        if ($data['assignedTo'] != '0') {
            $where[] = 't.assignedTo = :assignedTo';
            $params[':assignedTo'] = $data['assignedTo'];
        }

        if ($data['impact'] != '0') {
            $where[] = 't.impact = :impact';
            $params[':impact'] = $data['impact'];
        }

        if ($data['lastUpdatedBy'] != '0') {
            $where[] = 't.lastUpdatedBy = :lastUpdatedBy';
            $params[':lastUpdatedBy'] = $data['lastUpdatedBy'];
        }

        if (strlen($data['textSearch']) > 0) {
            $where[] = 't.problemType LIKE :textSearch OR t.problemDescription LIKE :textSearch OR t.notes LIKE :textSearch';
            $params[':textSearch'] = '%' . $data['textSearch'] . '%';
        }

        if (count($where) == 0) {
            return $this->_db->fetchAll($sql);
        }

        $whereClause = implode(' AND ', $where);

        $sql .= 'WHERE ' . $whereClause;

        d($sql);
        d($params);

        return $this->_db->fetchAll($sql, $params);
    }

}
