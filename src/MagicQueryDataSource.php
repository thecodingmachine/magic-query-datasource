<?php

namespace Mouf\Database\MagicQuery;

use Doctrine\DBAL\Connection;
use Mouf\Database\MagicQuery;
use Mouf\Utils\DataSource\Interfaces\DataSourceInterface;

class MagicQueryDataSource implements DataSourceInterface
{
    /**
     * @var string
     */
    private $query;

    /**
     * @var MagicQuery
     */
    private $magicQuery;

    /**
     * @var Connection
     */
    private $dbConnection;

    /**
     * @var array
     */
    private $parameters;

    /**
     * MagicQueryDataSource constructor.
     *
     * @param string $query
     * @param MagicQuery $magicQuery
     * @param Connection $dbConnection
     * @param array<string, string> $parameters
     */
    public function __construct($query, MagicQuery $magicQuery, Connection $dbConnection, array $parameters = [])
    {
        $this->query = $query;
        $this->magicQuery = $magicQuery;
        $this->dbConnection = $dbConnection;
        $this->parameters = $parameters;
    }

    /**
     * @param array $params
     */
    public function setParameters(array $params)
    {
        $this->parameters = $params;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $sql = $this->magicQuery->build($this->query, $this->parameters);
        return $this->dbConnection->fetchAll($sql, $this->parameters);
    }
}