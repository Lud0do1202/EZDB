<?php


class DeleteQuery implements IEditQuery
{
    // Empty Attributes
    private string $where = "";

    // Default Attributes
    private array $params = [];

    // Must Set Attributes
    private string $tables;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /* ********************************************************* */
    /* Where */
    public function where(string $where, ...$params): DeleteQuery
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

    /* ********************************************************* */
    /* Get Params */
    public function getParams(): array
    {
        return $this->params;
    }

    /* ********************************************************* */
    /* To String */
    public function __toString()
    {
        return "DELETE FROM {$this->table} {$this->where}";
    }
}
