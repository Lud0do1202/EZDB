<?php

class SelectQuery
{
    private string $columns, $tables;
    private string|null $distinct, $wheres, $orderBys;
    private array $params;

    public function __construct(string|array $tables)
    {
        $this->distinct = null;
        $this->columns = "*";
        $this->tables = is_array($tables) ? join(', ', $tables) : $tables;
        $this->wheres = null;
        $this->orderBys = null;
        $this->params = [];
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

    /* To String */
    public function __toString()
    {
        // Select
        $query = "SELECT ";

        // Distinct
        $query .= $this->distinct ?? "";

        // Columns
        $query .= " {$this->columns}";

        // Tables
        $query .= " FROM {$this->tables}";

        // Where
        if ($this->wheres != null)
            $query .= " WHERE {$this->wheres}";

        // Order By
        if ($this->orderBys != null)
            $query .= " ORDER BY {$this->orderBys}";

        return $query;
    }

    /* Params */
    public function getParams(): array
    {
        return $this->params;
    }
}
