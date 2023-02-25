<?php

class OrderBy
{
    private string $column, $direction;

    public function __construct(string $column, bool $asc = true)
    {
        $this->column = $column;
        $this->direction = $asc ? "ASC" : "DESC";
    }

    public function toQuery(): string
    {
        return $this->column . " " . $this->direction;
    }
}
