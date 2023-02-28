<?php


class UpdateQuery implements IEditQuery
{
    // Attributes
    private string $where = "";
    private array $argsSet = [];
    private array $argsWhere = [];

    // Must Set Attributes
    private string $table;
    private string $set;

    public function __construct(string $table, array ...$set)
    {
        $this->table = $table;

        $this->set = join(', ', array_map(function ($s) {
            $this->argsSet[] = $s[1];
            return $s[0] . " = ?";
        }, $set));
    }

    /* ********************************************************* */
    /* Where */
    public function where(string $where, ...$args): UpdateQuery
    {
        $convertArgs = new ConverterArgs($where, $args);

        $this->where = "WHERE " . $convertArgs->getQuery();
        $this->argsWhere = $convertArgs->getArgs();

        return $this;
    }

    /* Get Args */
    public function getArgs(): array
    {
        return array_merge($this->argsSet, $this->argsWhere);
    }

    /* To String */
    public function __toString()
    {
        // UPDATE $table SET $set
        $query = "UPDATE {$this->table} SET {$this->set} {$this->where}";

        return $query;
    }
}
