<?php

class EZDB
{
    private array $enum = [];
    private $nameEnum;

    /* Constructor */
    public function __construct(string $nameEnum = "EXAMPLE_EZDB")
    {
        $this->nameEnum = $nameEnum;
    }

    /* Add a new table with his columns */
    public function addTable(string $table, ?array $columns = []): void
    {
        if (isset($this->enum[$table])) return;

        $this->enum[$table] = [];
        foreach ($columns as $column)
            $this->enum[$table][] = $column;
    }

    /* Transform camel case to underscore case */
    private function camelCaseToUpperUnderscoreCase(string $camelCase): string
    {
        return strtoupper(preg_replace('/(?<!^)([A-Z])/', '_$1', $camelCase));
    }

    /* To String */
    private function toString(bool $phpFormat = true): string
    {
        // Beginning
        $s = "";
        if ($phpFormat)
            $s .= "<?php\n";
        $s .= "\nclass {$this->nameEnum}\n{\n";

        // Consts
        foreach ($this->enum as $table => $columns) {

            // Table name
            $s .= "\tconst " . $this->camelCaseToUpperUnderscoreCase($table) . " = '$table';\n";

            // Columns of this table
            foreach ($columns as $column)
                $s .= "\tconst " . $this->camelCaseToUpperUnderscoreCase($table) . "_" . $this->camelCaseToUpperUnderscoreCase($column) . " = '$column';\n";

            // Seperation
            $s .= "\t/*********************************/\n";
        }

        $s .= "}\n";
        return $s;
    }

    /* Display */
    public function display(): void
    {
        echo "<pre>" . $this->toString(false) . "</pre>";
    }

    /* Create the enum file */
    public function createFile(): void
    {
        // Open a new file for writing
        $filename = $this->nameEnum . ".php";
        $handle = fopen($filename, 'w');

        // Write some content to the file
        fwrite($handle, $this->toString());

        // Close the file handle
        fclose($handle);
    }
}
