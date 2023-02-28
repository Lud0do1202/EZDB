<?php

class SelectQuery implements ISelectQuery
{
    // Attributes
    private string $distinct = "";
    private string $limit = "";
    private string $columns = "*"; // Default *
    private string $where = "";
    private string $groupBy = "";
    private string $having = "";
    private string $orderBy = "";
    private array $argsWhere = [];
    private array $argsHaving = [];

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

        $convertArgs = new ConverterArgs($where, $args);

        $this->where = "WHERE " . $convertArgs->getQuery();
        $this->argsWhere = $convertArgs->getArgs();

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
    /* Having */
    public function having(string $having, ...$args): SelectQuery
    {

        $convertArgs = new ConverterArgs($having, $args);

        $this->having = "HAVING " . $convertArgs->getQuery();
        $this->argsHaving = $convertArgs->getArgs();

        return $this;
    }

    /* ********************************************************* */
    /* Order By */
    public function orderBy(...$orderBys): SelectQuery
    {
        $this->orderBy = "ORDER BY " . join(', ', array_map(function ($orderBy) {
            return is_array($orderBy) ? $orderBy[0] . ($orderBy[1] ? " ASC" : " DESC") : "$orderBy ASC";
        }, $orderBys));

        return $this;
    }

    /* ********************************************************* */
    /* Get Args */
    public function getArgs(): array
    {
        return array_merge($this->argsWhere, $this->argsHaving);
    }

    /* ********************************************************* */
    /* To String */
    public function __toString()
    {
        return "SELECT {$this->distinct} {$this->limit} {$this->columns} FROM {$this->tables} {$this->where} {$this->groupBy} {$this->having} {$this->orderBy}";
    }
}
