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
        // Debug
        if ($debug) $this->displayQuery($query);

        // Prepare query
        $stmt = $this->pdo->prepare($query);

        // Bind Params
        foreach ($query->getParams() as $i => $param)
            $stmt->bindValue($i + 1, $param);

        // Execute query
        $stmt->execute();

        // Return results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Edit */
    public function executeEdit(IEditQuery $query, ?bool $debug = false): int
    {
        // Debug
        if ($debug) $this->displayQuery($query);

        // Prepare query
        $stmt = $this->pdo->prepare($query);

        // Bind Params
        foreach ($query->getParams() as $i => $param)
            $stmt->bindValue($i + 1, $param);

        // Execute query
        $stmt->execute();

        // Return num rows affected
        return $stmt->rowCount();
    }

    /* Display query */
    private function displayQuery(IQuery $query): void
    {
        echo "<br><strong>$query<br><pre><i>";
        print_r($query->getParams());
        echo "</i></pre></strong><br>";
    }
}
