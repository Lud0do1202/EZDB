<?php


class UpdateQuery implements IEditQuery
{
    // Attributes
    private string $where = "";
    private array $params = [];

    // Must Set Attributes
    private string $table;
    private string $set;

    public function __construct(string $table, array ...$set)
    {
        $this->table = $table;

        $this->set = join(', ', array_map(function ($s) {
            $this->params[] = $s[1];
            return $s[0] . " = ?";
        }, $set));
    }

    /* ********************************************************* */
    /* Where */
    public function where(string $where, ...$params): UpdateQuery
    {
        // EXAMPLE
        // Where (idUser = idPost AND tot = 0) OR tot > 1000
        $example = "(% = % AND % = ?) OR % > ?";

        // Split into a table the string $where
        $split = str_split($where);

        // replace % by the value
        // Stock the value of ? into $this->params
        $count = count($split);
        for ($i = $j = 0; $i < $count; $i++) {
            switch ($split[$i]) {
                case '%':
                    $split[$i] = $params[$j++];
                    break;
                case '?':
                    $this->params[] = $params[$j++];
                    break;
            }
        }

        // Join the table
        $this->where = "WHERE " . join("", $split);

        return $this;
    }

    /* Get Params */
    public function getParams(): array
    {
        return $this->params;
    }

    /* To String */
    public function __toString()
    {
        // UPDATE $table SET $set
        $query = "UPDATE {$this->table} SET {$this->set} {$this->where}";

        return $query;
    }
}
