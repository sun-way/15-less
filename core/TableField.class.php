<?php
class TableField extends Connection
{
    protected $table;
    protected $name;
    protected $type;
    protected $null;
    protected $key;
    protected $default;
    protected $extra;
    public function __construct($tableName, $tableField)
    {
        $this->table = $tableName;
        $this->name = $tableField['Field'];
        $this->type = $tableField['Type'];
        $this->null = $tableField['Null'];
        $this->key = $tableField['Key'];
        $this->default = $tableField['Default'];
        $this->extra = $tableField['Extra'];
    }
    /**
     * Удаляет колонку из таблицы
     */
    public function delete()
    {
        $tableName = $this->getTable();
        $fieldName = $this->getName();
        $sql = "ALTER TABLE `$tableName` DROP COLUMN `$fieldName`;";
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute();
    }
    /**
     * Возвращает имя таблицы
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }
    /**
     * Возвращает имя колонки
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Устанавливает имя колонки
     * @param $name
     */
    public function setName($name)
    {
        $tableName = $this->getTable();
        $fieldType = $this->getNull() === 'NO' ? $this->getType() . ' NOT NULL' : $this->getType();
        $oldFieldName = $this->getName();
        $sql = "ALTER TABLE `$tableName` CHANGE `$oldFieldName` `$name` $fieldType";
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute();
        $this->name = $name;
    }
    public function getNull()
    {
        return $this->null;
    }
    public function getType()
    {
        return $this->type;
    }
    /**
     * Устанавливает тип колонки
     * @param $type
     */
    public function setType($type)
    {
        $tableName = $this->getTable();
        $fieldType = $this->getNull() === 'NO' ? $type . ' NOT NULL' : $type;
        $fieldName = $this->getName();
        $sql = "ALTER TABLE `$tableName` CHANGE `$fieldName` `$fieldName` $fieldType";
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute();
        $this->type = $type;
    }
    public function getKey()
    {
        return $this->key;
    }
    public function getDefault()
    {
        return $this->default;
    }
    public function getExtra()
    {
        return $this->extra;
    }
}