<?php

class DBTuple
{
    private string $column;
    private $value;

    public function __construct(string $column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getValue()
    {
        return $this->value;
    }
}
