<?php

namespace Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOException;
use Symfony\Component\HttpKernel\DataCollector\ExceptionDataCollector;

/**
 * Class PartRepository
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
     * @param $title
     * @return mixed
     */
    public function fetchByTitle($title)
    {
        return $this->db->fetchAll('SELECT * FROM parts WHERE title LIKE ?', ['%'.$title.'%']);
    }

    public function insert($data)
    {
        try {
            $this->db->insert('parts', $data);
        } catch (PDOException $e) {
            return false;
        }

        return true;
    }
}
