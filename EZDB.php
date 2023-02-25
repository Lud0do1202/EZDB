<?php

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

        foreach ($params as $key => $value)
            $stmt->bindValue($key, $value);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Edit (insert, update, delete) --> return num row affected */
    public function executeEdit(string $query, ?array $params = []): int
    {
        $stmt = $this->pdo->prepare($query);
        echo "<br>$query";

        foreach ($params as $key => $value)
            $stmt->bindValue(":$key", $value);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
