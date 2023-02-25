<?php

class Where
{
    private Param $param;
    private string $operator;

    public function __construct(Param $param, string $operator)
    {
        $this->param = $param;
        $this->operator = $operator;
    }

    public function toQueryNotBind(): string
    {
        return $this->param->getColumn() . " " . $this->operator . " " . $this->param->getParam();
    }

    public function getParam()
    {
        return $this->param;
    }
}
