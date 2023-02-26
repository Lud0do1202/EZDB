<?php

class UpdateQuery implements IEditQuery
{
    // Empty Attributes
    private string $wheres = "";

    // Default Attributes
    private array $params = [];

    // Must Set Attributes
    private string $table;
    private string $set;

    public function __construct(string $table, DBTuple|array $dbTuples)
    {
        $this->table = $table;

        if (is_array($dbTuples)) {
            $this->set = join(', ', array_map(function ($tuple) {
                $this->params[] = $tuple->getValue();
                return $tuple->getColumn() . " = ?";
            }, $dbTuples));
        } else {
            $this->params[] = $dbTuples->getValue();
            $this->set = $dbTuples->getColumn() . " = ?";
        }
    }

    /* Where */
    public function where(W|array $wheres): UpdateQuery
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
    public function getParams(): array
    {
        return $this->params;
    }

    /* To String */
    public function __toString()
    {
        // UPDATE $table SET $set
        $query = "UPDATE {$this->table} SET {$this->set} ";

        // Wheres
        if (!empty($this->wheres))
            $query .= "WHERE {$this->wheres} ";

        return $query;
    }
}
