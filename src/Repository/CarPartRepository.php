<?php

namespace Repository;

use Doctrine\DBAL\Connection;

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
     * @return mixed
     */
    public function fetchAll()
    {
        return $this->db->fetchAll("SELECT * FROM parts");
    }
}
