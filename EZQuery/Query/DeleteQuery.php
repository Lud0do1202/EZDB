<?php


class DeleteQuery extends SEditQuery
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
        $convertArg = $this->convertArgs($where, $args);

        $this->where = "WHERE " . $convertArg[0];
        $this->args = $convertArg[1];

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
