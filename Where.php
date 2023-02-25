<?php

class Where
{
    private ColumnValue $colVal;
    private string $operator;

    public function __construct(ColumnValue $colVal, string $operator)
    {
        $this->colVal = $colVal;
        $this->operator = $operator;
    }

    public function toQueryNotBind(): string
    {
        return $this->colVal->getColumn() . " " . $this->operator . " " . $this->colVal->getParam();
    }

    public function getColumnValue()
    {
        return $this->colVal;
    }
}
