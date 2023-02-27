<?php

class SelectQuery implements ISelectQuery
{
    // Empty Attributes
    private string $distinct = "";
    private string $limit = "";
    private string $where = "";
    private string $orderBy = "";

    // Default Attributes
    private string $columns = "*";
    private array $params = [];

    // Must Set Attributes
    private string $tables;

    public function __construct(string ...$tables)
    {
        $this->tables = join(', ', $tables);
    }

    /* ********************************************************* */
    /* Distinct */
    public function distinct(): SelectQuery
    {
        $this->distinct = "DISTINCT";
        return $this;
    }

    /* ********************************************************* */
    /* Limit */
    public function limit(int $n): SelectQuery
    {
        $this->limit = "LIMIT ($n)";
        return $this;
    }

    /* ********************************************************* */
    /* Select Column */
    public function columns(string ...$columns): SelectQuery
    {
        $this->columns = join(', ', $columns);
        return $this;
    }

    /* ********************************************************* */
    /* Where */
    public function where(string $where, ...$params): SelectQuery
    {
        // EXAMPLE
        // Where (idUser = idPost AND tot = 0) OR tot > 1000
        $example = "(% = % AND % = ?) OR % > ?";

        // Split into a table the string $where
        $split = str_split($where);

        // replace % by the value
        // Stock the value of ? into $this->params
        $count = count($split);
        for ($i = $j = 0; $i < $count; $i++) {
            switch ($split[$i]) {
                case '%':
                    $split[$i] = $params[$j++];
                    break;
                case '?':
                    $this->params[] = $params[$j++];
                    break;
            }
        }

        // Join the table
        $this->where = "WHERE " . join("", $split);

        return $this;
    }

    /* ********************************************************* */
    /* Order By */
    public function orderBy(...$orderBys): SelectQuery
    {
        $this->orderBy = "ORDER BY " . join(', ', array_map(function($orderBy){
            return is_array($orderBy) ? $orderBy[0] . ($orderBy[1] ? " ASC" : " DESC") : "$orderBy ASC";
        }, $orderBys));

        return $this;
    }

    /* ********************************************************* */
    /* Get Params */
    public function getParams(): array
    {
        return $this->params;
    }

    /* ********************************************************* */
    /* To String */
    public function __toString()
    {
        return "SELECT {$this->distinct} {$this->limit} {$this->columns} FROM {$this->tables} {$this->where} {$this->orderBy}";
    }
}
