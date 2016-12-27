<?php

namespace Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOException;

/**
 * Class CarTypeRepository
 * @package Repository
 */
class CarTypeRepository
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * CarTypeRepository constructor.
     * @param Connection $dbConnection
     */
    public function __construct(Connection $dbConnection)
    {
        $this->db = $dbConnection;
    }

    /**
     * Sql inject me bro.
     * @param $title
     * @return mixed
     */
    public function fetchByTitle($title)
    {
        return $this->db->fetchAll('SELECT * FROM models WHERE title LIKE ?', ['%'.$title.'%']);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function fetchById($id)
    {
        return $this->db->fetchAssoc('SELECT * FROM models WHERE id = ?', [$id]);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->db->delete('models', ['id' => $id]);
    }

    /**
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $this->db->update('models', $data, ['id' => $id]);
    }

    /**
     * @param $data
     * @return bool
     */
    public function insert($data)
    {
        try {
            $this->db->insert('models', $data);
        } catch (PDOException $e) {
            return false;
        }

        return true;
    }

    public function getArray()
    {
        $result = [];
        $types = $this->db->fetchAll('SELECT title FROM models');
        foreach ($types as $type) {
            $result[$type['title']] = $type['title'];
        }

        return $result;
    }
}
