<?php

namespace Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOException;
use PDO;

/**
 * Class CarPartRepository
 * @package Repository
 */
class CarPartRepository
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * CarPartRepository constructor.
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
        return $this->db->fetchAll('SELECT * FROM parts WHERE title LIKE ?', ['%'.$title.'%']);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function fetchById($id)
    {
        return $this->db->fetchAssoc('SELECT * FROM parts WHERE id = ?', [$id]);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->db->delete('parts', ['id' => $id]);
    }

    /**
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $this->db->update('parts', $data, ['id' => $id]);
    }

    /**
     * @param $data
     * @return bool
     */
    public function insert($data)
    {
        try {
            $this->db->insert('parts', $data);
        } catch (PDOException $e) {
            return false;
        }

        return true;
    }

    /**
     * @param $type
     * @return int
     */
    public function getPartCount($type)
    {
        $query = $this->db->prepare('SELECT SUM(qnt) FROM parts WHERE type = :type');
        $query->bindValue('type', $type, PDO::PARAM_STR);
        $query->execute();

        return $query->fetchColumn(0);
    }
}
