<?php

class DeleteQuery implements IEditQuery
{
    // Empty Attributes
    private string $wheres = "";

    // Default Attributes
    private array $params = [];

    // Must Set Attributes
    private string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /* Where */
    public function where(Where|array $wheres): DeleteQuery
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

    /* Get Params */
    public function getParams() : array
    {
        return $this->params;
    }

    /* To String */
    public function __toString()
    {
        // DELETE FROM $table
        $query = "DELETE FROM {$this->table} ";

        // Wheres
        if (!empty($this->wheres))
            $query .= "WHERE {$this->wheres} ";

        return $query;
    }
}
