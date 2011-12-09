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

    public function find($ticketId)
    {
        $sql = $this->getTicketSql();
        $sql .= ' WHERE t.ticketId = ?';
        return $this->_db->query($sql, array($ticketId))->fetch();
    }

    /**
     * Fetch all tickets
     *
     * @return array
     */
    public function fetchAll()
    {
        $sql = $this->getTicketSql();
        return $this->_db->fetchAll($sql);
    }

    /**
     * Searches ticket database
     *
     * @param array $data
     * @return array Search results
     */
    public function search(array $data)
    {

        $where = array();
        $bind = array();

        if (strlen($data['ticketId']) >= 6) {
            $where[] = 't.ticketId = :ticketId';
            $bind[':ticketId'] = $data['ticketId'];
        }

        if ($data['status'] != '0') {
            $where[] = 't.status = :status';
            $bind[':status'] = $data['status'];
        }

        if ($data['createdBy'] != '0') {
            $where[] = 't.createdBy = :createdBy';
            $bind[':createdBy'] = $data['createdBy'];
        }

        if ($data['assignedTo'] != '0') {
            $where[] = 't.assignedTo = :assignedTo';
            $bind[':assignedTo'] = $data['assignedTo'];
        }

        if ($data['impact'] != '0') {
            $where[] = 't.impact = :impact';
            $bind[':impact'] = $data['impact'];
        }

        if ($data['lastUpdatedBy'] != '0') {
            $where[] = 't.lastUpdatedBy = :lastUpdatedBy';
            $bind[':lastUpdatedBy'] = $data['lastUpdatedBy'];
        }

        if (strlen($data['textSearch']) > 0) {
            $where[] = 't.problemType LIKE :textSearch OR t.problemDescription LIKE :textSearch OR t.notes LIKE :textSearch';
            $bind[':textSearch'] = '%' . $data['textSearch'] . '%';
        }

        $sql = $this->getTicketSql();

        if (count($where) == 0) {
            return $this->_db->fetchAll($sql);
        }

        $sql .= ' WHERE ' . implode(' AND ', $where);

        return $this->_db->fetchAll($sql, $bind);
    }

    public function getTicketSql()
    {
        return 'SELECT t.*, a.username AS assignedTo, c.username AS createdBy, up.username AS lastUpdatedBy '
            . 'FROM tickets AS t '
            . 'LEFT JOIN users AS a '
            . 'ON t.assignedTo = a.userId '
            . 'JOIN users AS c '
            . 'ON t.createdBy = c.userId '
            . 'JOIN users AS up '
            . 'ON t.lastUpdatedBy = up.userId';
    }

}
