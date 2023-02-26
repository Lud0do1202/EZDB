<?php
require_once "../Struct/OrderBy.php";
require_once "../Struct/W.php";
require_once "../Struct/DBTuple.php";

require_once "../Query/Query.php";
require_once "../Query/SelectQuery.php";
require_once "../Query/InsertQuery.php";
require_once "../Query/DeleteQuery.php";
require_once "../Query/UpdateQuery.php";

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
    public function executeSelectV2(ISelectQuery $query): array
    {
        $stmt = $this->pdo->prepare($query);

        foreach ($query->getParams() as $i => $param)
            $stmt->bindValue($i + 1, $param);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Edit */
    public function executeEditV2(IEditQuery $query): int
    {
        $stmt = $this->pdo->prepare($query);

        foreach ($query->getParams() as $i => $param)
            $stmt->bindValue($i + 1, $param);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
