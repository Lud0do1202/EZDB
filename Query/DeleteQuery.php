<?php

class DeleteQuery implements EditQuery
{
    private string $table;
    private string|null $wheres;
    private array $params;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->wheres = null;
        $this->params = [];
    }

    /* Where */
    public function where(W|array $wheres): DeleteQuery
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

    /* To String */
    public function __toString()
    {
        // DELETE FROM $table
        $query = "DELETE FROM {$this->table} ";

        // Wheres
        if ($this->wheres != null)
            $query .= "WHERE {$this->wheres} ";

        return $query;
    }

    /* Params */
    public function getParams(): array
    {
        return $this->params;
    }
}
