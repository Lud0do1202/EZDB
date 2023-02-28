<?php

// Query
require_once "./Query/Query.php";
require_once "./Query/SelectQuery.php";
require_once "./Query/InsertQuery.php";
require_once "./Query/DeleteQuery.php";
require_once "./Query/UpdateQuery.php";

class EZQuery
{
    private PDO $pdo;
    private bool $debug = false;

    public function __construct(string $host, string $dbname, string $username, string $password)
    {
        /* Connection to the db */
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
    }

    /* Debug */
    public function debug(?bool $debug = true) : void
    {
        $this->debug = $debug;
    }

    /* Select */
    public function executeSelect(SSelectQuery $query): array
    {
        // Debug
        if ($this->debug) $this->displayQuery($query, $query->getArgs());

        // Prepare query
        $stmt = $this->pdo->prepare($query);

        // Bind Args
        foreach ($query->getArgs() as $i => $arg)
            $stmt->bindValue($i + 1, $arg);

        // Execute query
        $stmt->execute();

        // Return results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Select */
    public function sexecuteSelect(string $query, ...$args): array
    {
        // Replace % ? by args
        $bindArgs = [];
        $split = str_split($query);
        $count = count($split);
        for ($i = $j = 0; $i < $count; $i++) {
            switch ($split[$i]) {
                case '%':
                    $split[$i] = $args[$j++];
                    break;
                case '?':
                    $bindArgs[] = $args[$j++];
                    break;
            }
        }
        $query = join("", $split);

        // Debug
        if ($this->debug) $this->displayQuery($query, $args);

        // Prepare query
        $stmt = $this->pdo->prepare($query);

        // Bind Args
        foreach ($bindArgs as $i => $arg)
            $stmt->bindValue($i + 1, $arg);

        // Execute query
        $stmt->execute();

        // Return results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Edit */
    public function executeEdit(SEditQuery $query): int
    {
        // Debug
        if ($this->debug) $this->displayQuery($query, $query->getArgs());

        // Prepare query
        $stmt = $this->pdo->prepare($query);

        // Bind Args
        foreach ($query->getArgs() as $i => $arg)
            $stmt->bindValue($i + 1, $arg);

        // Execute query
        $stmt->execute();

        // Return num rows affected
        return $stmt->rowCount();
    }

    public function sexecuteEdit(string $query, ...$args): int
    {
        // Replace % ? by args
        $bindArgs = [];
        $split = str_split($query);
        $count = count($split);
        for ($i = $j = 0; $i < $count; $i++) {
            switch ($split[$i]) {
                case '%':
                    $split[$i] = $args[$j++];
                    break;
                case '?':
                    $bindArgs[] = $args[$j++];
                    break;
            }
        }
        $query = join("", $split);

        // Debug
        if ($this->debug) $this->displayQuery($query, $bindArgs);

        // Prepare query
        $stmt = $this->pdo->prepare($query);

        // Bind Args
        foreach ($bindArgs as $i => $arg)
            $stmt->bindValue($i + 1, $arg);

        // Execute query
        $stmt->execute();

        // Return num rows affected
        return $stmt->rowCount();
    }

    /*  */

    /* Display query */
    private function displayQuery(string $query, array $args): void
    {
        echo "<br><strong>$query<br><pre><i>";
        print_r($args);
        echo "</i></pre></strong><br>";
    }
}
