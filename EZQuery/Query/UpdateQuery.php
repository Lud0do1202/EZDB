<?php


class UpdateQuery implements IEditQuery
{
    // Attributes
    private string $where = "";
    private array $args = [];

    // Must Set Attributes
    private string $table;
    private string $set;

    public function __construct(string $table, array ...$set)
    {
        $this->table = $table;

        $this->set = join(', ', array_map(function ($s) {
            $this->args[] = $s[1];
            return $s[0] . " = ?";
        }, $set));
    }

    /* ********************************************************* */
    /* Where */
    public function where(string $where, ...$args): UpdateQuery
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

    /* Get Args */
    public function getArgs(): array
    {
        return $this->args;
    }

    /* To String */
    public function __toString()
    {
        // UPDATE $table SET $set
        $query = "UPDATE {$this->table} SET {$this->set} {$this->where}";

        return $query;
    }
}
