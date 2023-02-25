<?php

class ColumnValue
{
    private $column, $value;

    public function __construct(string $column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    public function getParam()
    {
        return ":" . str_replace(".", "_", $this->column);
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getValue()
    {
        return $this->value;
    }
}
