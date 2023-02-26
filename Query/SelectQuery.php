<?php

class SelectQuery implements ISelectQuery
{
    // Empty Attributes
    private string $distinct = "";
    private string $wheres = "";
    private string $orderBys = "";

    // Default Attributes
    private string $columns = "*";
    private array $params = [];

    // Must Set Attributes
    private string $tables;

    public function __construct(string|array $tables)
    {
        $this->tables = is_array($tables) ? join(', ', $tables) : $tables;
    }

    /* Distinct */
    public function distinct(): SelectQuery
    {
        $this->distinct = "DISTINCT";
        return $this;
    }

    /* Select Column */
    public function columns(string|array $columns): SelectQuery
    {
        $this->columns = is_array($columns) ? join(', ', $columns) : $columns;
        return $this;
    }

    /* Where */
    public function where(W|array $wheres): SelectQuery
    {
        if (is_array($wheres)) {
            $this->wheres = join(' AND ', array_map(function ($where) {
                if ($where->toBind()) {
                    $this->params[] = $where->getValue();
                    return $where->toQueryToBind();
                } else {
                    return $where->toQuery();
                }
            }, $wheres));
        } else {
            if ($wheres->toBind()) {
                $this->params[] = $wheres->getValue();
                $this->wheres = $wheres->toQueryToBind();
            } else {
                $this->wheres = $wheres->toQuery();
            }
        }

        return $this;
    }

    /* Order By */
    public function orderBy(OrderBy|array $orderBys): SelectQuery
    {
        if (is_array($orderBys)) {
            $this->orderBys = join(' AND ', array_map(function ($orderBy) {
                return $orderBy->toQuery();
            }, $orderBys));
        } else {
            $this->orderBys = $orderBys->toQuery();
        }
        return $this;
    }

    /* Get Params */
    public function getParams() : array
    {
        return $this->params;
    }

    /* To String */
    public function __toString()
    {
        // Select
        $query = "SELECT ";

        // Distinct
        $query .= "{$this->distinct} ";

        // Columns
        $query .= "{$this->columns} ";

        // Tables
        $query .= "FROM {$this->tables} ";

        // Where
        if (!empty($this->wheres))
            $query .= "WHERE {$this->wheres} ";

        // Order By
        if (!empty($this->orderBys))
            $query .= "ORDER BY {$this->orderBys}";

        return $query;
    }
}
