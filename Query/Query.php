<?php

interface IQuery
{
    public function getParams(): array;
    public function __toString();
}


interface IEditQuery extends IQuery
{
}
interface ISelectQuery extends IQuery
{
}
