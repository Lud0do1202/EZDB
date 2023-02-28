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
        $convertArgs = new ConverterArgs($where, $args);

        $this->where = "WHERE " . $convertArgs->getQuery();
        $this->args = $convertArgs->getArgs();

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
