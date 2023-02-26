<?php

class InsertQuery implements IEditQuery
{
    // Empty Attributes
    private string $columns = "";
    private string $values = "";

    // Default Attributes
    private array $params = [];

    // Must Set Attributes
    private string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
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
    
    /* Get Params */
    public function getParams() : array
    {
        return $this->params;
    }

    /* To String */
    public function __toString()
    {
        // INSERT INTO $table
        $query = "INSERT INTO {$this->table} ";

        // Columns
        if (!empty($this->columns))
            $query .= "({$this->columns}) ";

        // Values
        $query .= "VALUES ";

        // The values
        if (!empty($this->values))
            $query .= "({$this->values})";

        return $query;
    }
}
