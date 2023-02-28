<?php


class DeleteQuery implements IEditQuery
{
    // Attributes
    private string $where = "";
    private array $args = [];

    // Must Set Attributes
    private string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /* ********************************************************* */
    /* Where */
    public function where(string $where, ...$args): DeleteQuery
    {
        // Split into a table the string $where
        $split = str_split($where);

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

        // Join the table
        $this->where = "WHERE " . join("", $split);

        return $this;
    }

    /* ********************************************************* */
    /* Get Args */
    public function getArgs(): array
    {
        return $this->args;
    }

    /* ********************************************************* */
    /* To String */
    public function __toString()
    {
        return "DELETE FROM {$this->table} {$this->where}";
    }
}
