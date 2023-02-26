<?php

class Where
{
    private string $column, $operator;
    private bool $toBind;
    private $value;

    public function __construct(string $column, string $operator, $value, bool $toBind = true)
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
        $this->toBind = $toBind;
    }

    public function toQueryToBind(): string
    {
        return "{$this->column} {$this->operator} ?";
    }

    public function toQuery(): string
    {
        return "{$this->column} {$this->operator} {$this->value}";
    }

    public function toBind(): bool
    {
        return $this->toBind;
    }

    public function getValue()
    {
        return $this->value;
    }
}
