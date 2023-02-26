<?php

class InsertQuery implements EditQuery
{
    private string $table;
    private string|null $columns, $values;
    private array $params;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->columns = null;
        $this->values = null;
        $this->params = [];
    }

    /* Columns */
    public function columns(DBTuple|array $dbTuples): InsertQuery
    {
        if (is_array($dbTuples)) {
            $this->columns = join(', ', array_map(function ($tuple) {
                $this->params[] = $tuple->getValue();
                return $tuple->getColumn();
            }, $dbTuples));

            $this->values = join(', ', str_split(str_repeat("?", count($dbTuples))));
        } else {
            $this->params[] = $dbTuples->getValue();
            $this->columns = $dbTuples->getColumn();
            $this->values = "?";
        }
        return $this;
    }

    /* To String */
    public function __toString()
    {
        // INSERT INTO $table
        $query = "INSERT INTO {$this->table} ";

        // Columns
        if ($this->columns != null)
            $query .= "({$this->columns}) ";

        // Values
        $query .= "VALUES ";

        // The values
        if ($this->values != null)
            $query .= "({$this->values})";

        return $query;
    }

    /* Params */
    public function getParams(): array
    {
        return $this->params;
    }
}
