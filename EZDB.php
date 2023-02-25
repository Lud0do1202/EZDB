<?php
require_once "Param.php";
require_once "Where.php";

class EZDB
{
    private PDO $pdo;

    public function __construct(string $host, string $dbname, string $username, string $password)
    {
        /* Connection to the db */
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
    }

    /* Select --> return associative array */
    public function executeSelect(string $query, ?array $params = []): array
    {
        $stmt = $this->pdo->prepare($query);

        foreach ($params as $param)
            $stmt->bindValue($param->getParam(), $param->getValue());

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Edit (insert, update, delete) --> return num row affected */
    public function executeEdit(string $query, ?array $params = []): int
    {
        $stmt = $this->pdo->prepare($query);

        foreach ($params as $param)
            $stmt->bindValue($param->getParam(), $param->getValue());

        $stmt->execute();

        return $stmt->rowCount();
    }

    /* Insert Into */
    public function insertInto(string $table, ?array $params = []): int
    {
        // Columns --> c1, c2, c3
        $c = join(', ', array_map(function ($param) {
            return $param->getColumn();
        }, $params));

        // Params  --> :c1, :c2, :c3
        $p = join(', ', array_map(function ($param) {
            return $param->getParam();
        }, $params));

        // Query
        $insertInto = "INSERT INTO $table ($c) VALUES ($p)";

        // Execute
        return $this->executeEdit($insertInto, $params);
    }

    /* Delete */
    public function delete(string $table, ?array $wheres = []): int
    {
        // Where --> c1 < :c1 AND c2 = :c2
        $w = join(' AND ', array_map(function ($where) {
            return $where->toQueryNotBind();
        }, $wheres));

        // Query
        $delete = "DELETE FROM $table";
        if(!empty($wheres))
            $delete .= " WHERE $w";

        // Get Params
        $params = [];
        foreach ($wheres as $where)
            $params[] = $where->getParam();

        // Execute
        return $this->executeEdit($delete, $params);
    }
}
