<?php
class DataBase extends Connection
{
    public function __construct($tableName)
    {
        $sqlCreateTable =
            "CREATE TABLE IF NOT EXISTS `$tableName` (
              id int NOT NULL AUTO_INCREMENT,
              name char NOT NULL,
              telephone varchar(10) NOT NULL,
              money int NOT NULL DEFAULT 0,
              PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $statement = $this->getConnection()->prepare($sqlCreateTable);
        $statement->execute([]);
    }
    /**
     * Возвращает массив объектов класса Table
     * @return Table[]
     */
    public function getTables()
    {
        $sql = "SHOW TABLES";
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute();
        $tables = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $table) {
            $tables[] = new Table($table['Tables_in_' . DB]);
        }
        return $tables;
    }
    /**
     * Возвращает объект класса Table с именем $tableName
     * @param $tableName
     * @return Table
     */
    public function getTable($tableName)
    {
        $table = new Table($tableName);
        return $table;
    }
}