<?php

class ConverterArgs
{
    private string $query;
    private array $args = [];

    public function __construct(string $query, array $args)
    {
        // Split into a table the string $where
        $split = str_split($query);

        // replace % by the value
        // Stock the value of ? into $this->args
        $count = count($split);
        for ($i = $j = 0; $i < $count; $i++) {
            switch ($split[$i]) {
                case '%':
                    $split[$i] = $args[$j++];
                    break;
                case '?':
                    $this->args[] = $args[$j++];
                    break;
            }
        }

        $this->query = join('', $split);
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getArgs(): array
    {
        return $this->args;
    }
}
