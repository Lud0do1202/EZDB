<?php

abstract class Query
{
    protected function convertArgs(string $s, array $args): array
    {
        // Bind args
        $bindArgs = [];

        // Split into a table the string $where
        $split = str_split($s);

        // replace % by the value
        // Stock the value of ? into $this->args
        $count = count($split);
        for ($i = $j = 0; $i < $count; $i++) {
            switch ($split[$i]) {
                case '%':
                    $split[$i] = $args[$j++];
                    break;
                case '?':
                    $bindArgs[] = $args[$j++];
                    break;
            }
        }

        // Join the table
        return [join("", $split), $bindArgs];
    }

    abstract public function getArgs();
    abstract public function __toString();
}

abstract class SEditQuery extends Query
{
}
abstract class SSelectQuery extends Query
{
}
