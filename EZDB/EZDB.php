<?php
require_once "../ColumnValue.php";
require_once "../Struct/OrderBy.php";
require_once "../Where.php";
require_once "../Struct/W.php";
require_once "../Struct/DBTuple.php";
require_once "../Query/SelectQuery.php";
require_once "../Query/EditQuery.php";
require_once "../Query/InsertQuery.php";

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

    // /////////////////////////////////////////////////////////
    // /////////////////////////////////////////////////////////
    /* Select */
    public function executeSelectV2(SelectQuery $query): array
    {
        echo "<br>$query";
        $stmt = $this->pdo->prepare($query);

        foreach ($query->getParams() as $i => $param)
            $stmt->bindValue($i + 1, $param);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Edit */
    public function executeEditV2(EditQuery $query): int
    {
        echo "<br>$query";
        $stmt = $this->pdo->prepare($query);

        foreach ($query->getParams() as $i => $param)
            $stmt->bindValue($i + 1, $param);

        $stmt->execute();

        return $stmt->rowCount();
    }
    // /////////////////////////////////////////////////////////
    // /////////////////////////////////////////////////////////

    /* Select --> return associative array */
    public function executeSelect(string $query, array $params = []): array
    {
        $stmt = $this->pdo->prepare($query);
        echo "*** $query";

        foreach ($params as $param)
            $stmt->bindValue($param->getParam(), $param->getValue());

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Edit (insert, update, delete) --> return num row affected */
    public function executeEdit(string $query, array $colVals = []): int
    {
        $stmt = $this->pdo->prepare($query);

        foreach ($colVals as $colVal)
            $stmt->bindValue($colVal->getParam(), $colVal->getValue());

        $stmt->execute();

        return $stmt->rowCount();
    }

    

    public function select(string $table, array|string $columns = "*", array $wheres = [], array $orderBys = []): array
    {
        // Columns --> c1, c2, c3
        $c = is_array($columns) ? join(', ', $columns) : $columns;

        // Where --> c1 < :c1 AND c2 = :c2
        $w = join(' AND ', array_map(function ($where) {
            return $where->toQueryNotBind();
        }, $wheres));

        // Order by
        $o = join(', ', array_map(function ($orderBy) {
            return $orderBy->toQuery();
        }, $orderBys));

        // Query
        $select = "SELECT $c FROM $table";
        if (!empty($wheres))
            $select .= " WHERE $w";
        if (!empty($orderBys))
            $select .= " ORDER BY $o";
        echo $select;

        // Get Params
        $colVals = [];
        foreach ($wheres as $where)
            $colVals[] = $where->getColumnValue();

        return $this->executeSelect($select, $colVals);
    }

    /* Insert Into */
    public function insertInto(string $table, array $colVals = []): int
    {
        // Columns --> c1, c2, c3
        $c = join(', ', array_map(function ($colVal) {
            return $colVal->getColumn();
        }, $colVals));

        // Params  --> :c1, :c2, :c3
        $p = join(', ', array_map(function ($colVal) {
            return $colVal->getParam();
        }, $colVals));

        // Query
        $insertInto = "INSERT INTO $table ($c) VALUES ($p)";

        // Execute
        return $this->executeEdit($insertInto, $colVals);
    }

    /* Update */
    public function update(string $table, array $colVals, array $wheres = []): int
    {
        // Set   --> c1 = :c1, c2 = :c2
        $s = join(', ', array_map(function ($colVal) {
            return $colVal->getColumn() . " = " . $colVal->getParam();
        }, $colVals));

        // Where --> c1 < :c1 AND c2 = :c2
        $w = join(' AND ', array_map(function ($where) {
            return $where->toQueryNotBind();
        }, $wheres));

        // Query
        $delete = "UPDATE $table SET $s";
        if (!empty($wheres))
            $delete .= " WHERE $w";

        // Get Params
        foreach ($wheres as $where)
            $colVals[] = $where->getColumnValue();

        // Execute
        return $this->executeEdit($delete, $colVals);
    }

    /* Delete */
    public function delete(string $table, array $wheres = []): int
    {
        // Where --> c1 < :c1 AND c2 = :c2
        $w = join(' AND ', array_map(function ($where) {
            return $where->toQueryNotBind();
        }, $wheres));

        // Query
        $delete = "DELETE FROM $table";
        if (!empty($wheres))
            $delete .= " WHERE $w";

        // Get Params
        $colVals = [];
        foreach ($wheres as $where)
            $colVals[] = $where->getColumnValue();

        // Execute
        return $this->executeEdit($delete, $colVals);
    }
}
