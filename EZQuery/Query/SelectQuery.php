<?php

class SelectQuery implements ISelectQuery
{
    // Attributes
    private string $distinct = "";
    private string $limit = "";
    private string $where = "";
    private string $orderBy = "";
    private string $groupBy = "";
    private string $columns = "*";
    private array $args = [];

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
    public function where(string $where, ...$args): SelectQuery
    {
        // Split into a table the string $where
        $split = str_split($where);

        // replace % by the value
        // Stock the value of ? into $this->args
        $count = count($split);
        for ($i = $j = 0; $i < $count; $i++) {
            switch ($split[$i]) {
                case '%':
                    $split[$i] = $args[$j++];
                    break;
                case '?':
                    $this->args[] = $args[$j++];
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
    /* Group By */
    public function groupBy(...$groupBys): SelectQuery
    {
        $this->groupBy = "GROUP BY " . join(', ', $groupBys);

        return $this;
    }

    /* ********************************************************* */
    /* Get Args */
    public function getArgs(): array
    {
        return $this->args;
    }

    /* ********************************************************* */
    /* To String */
    public function __toString()
    {
        return "SELECT {$this->distinct} {$this->limit} {$this->columns} FROM {$this->tables} {$this->where} {$this->groupBy} {$this->orderBy}";
    }
}
