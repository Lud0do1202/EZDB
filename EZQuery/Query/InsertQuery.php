<?php

class InsertQuery implements IEditQuery
{
    // Default Attributes
    private string $columns = "";
    private string $values = "()";
    private array $params = [];

    // Must Set Attributes
    private string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /* ********************************************************* */
    /* Columns */
    public function columns(string ...$columns): InsertQuery
    {
        $this->columns = "(" . join(', ', $columns) . ")";
        return $this;
    }

    /* ********************************************************* */
    /* Values */
    public function values(string ...$values): InsertQuery
    {
        $this->values = "(" . join(', ', str_split(str_repeat("?", count($values))))  . ")";
        $this->params = $values;

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
        return "INSERT INTO {$this->table} {$this->columns} VALUES {$this->values}";
    }
}
