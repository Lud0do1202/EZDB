<?php

interface IQuery
{
    public function getArgs();
    public function __toString();
}

interface IEditQuery extends IQuery
{
}
interface ISelectQuery extends IQuery
{
}
