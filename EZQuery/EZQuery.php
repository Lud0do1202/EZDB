<?php

// Query
require_once "./Query/IQuery.php";
require_once "./Query/SelectQuery.php";
require_once "./Query/InsertQuery.php";
require_once "./Query/DeleteQuery.php";
require_once "./Query/UpdateQuery.php";

class EZQuery
{
    private PDO $pdo;

    public function __construct(string $host, string $dbname, string $username, string $password)
    {
        /* Connection to the db */
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
    }

    /* Select */
    public function executeSelect(ISelectQuery $query, ?bool $debug = false): array
    {
        return $this->sexecuteSelect($query, $query->getParams(), $debug);
    }

    /* Select */
    public function sexecuteSelect(string $query, ?array $params = [], ?bool $debug = false): array
    {
        // Debug
        if ($debug) $this->displayQuery($query, $params);


        // Prepare query
        $stmt = $this->pdo->prepare($query);

        // Bind Params
        foreach ($params as $i => $param)
            $stmt->bindValue($i + 1, $param);

        // Execute query
        $stmt->execute();

        // Return results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Edit */
    public function executeEdit(IEditQuery $query, ?bool $debug = false): int
    {
        return $this->sexecuteEdit($query, $query->getParams(), $debug);
    }

    public function sexecuteEdit(string $query, ?array $params = [], ?bool $debug = false): int
    {
        // Debug
        if ($debug) $this->displayQuery($query, $params);

        // Prepare query
        $stmt = $this->pdo->prepare($query);

        // Bind Params
        foreach ($params as $i => $param)
            $stmt->bindValue($i + 1, $param);

        // Execute query
        $stmt->execute();

        // Return num rows affected
        return $stmt->rowCount();
    }

    /* Display query */
    private function displayQuery(string $query, array $params): void
    {
        echo "<br><strong>$query<br><pre><i>";
        print_r($params);
        echo "</i></pre></strong><br>";
    }
}
