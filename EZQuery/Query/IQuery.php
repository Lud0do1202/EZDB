<?php

interface IQuery
{
    public function getParams();
    public function __toString();
}

interface IEditQuery extends IQuery
{
}
interface ISelectQuery extends IQuery
{
}
