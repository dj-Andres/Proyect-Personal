<?php

include_once 'conexion.php';

class baseModel
{
    public function __construct()
    {
        $db = new conexion();
        $this->acceso = $db->pdo;
    }

    /**
     * Method insert
     *
     * @param string $table [explicite description]
     * @param array $params [explicite description]
     * @param array $types [explicite description]
     *
     * @return void
     */
    public function insert(string $table, array $params, array $types = [])
    {
        if (count($params) === 0) {
            return $this->executeSql('INSERT INTO ' . $table . ' () VALUES ()');
        }

        $columns = [];
        $values  = [];
        $set     = [];

        foreach ($params as $columnName => $value) {
            $columns[] = $columnName;
            $values[]  = $value;
            $set[]     = '?';
        }

        return $this->executeSql(
            'INSERT INTO ' . $table . ' (' . implode(', ', $columns) . ')' .
                ' VALUES (' . implode(', ', $set) . ')',
            $values
        );
    }
    /**
     * Method executeSql
     *
     * @param $sql $sql [explicite description]
     * @param array $params [explicite description]
     * @param array $types [explicite description]
     *
     * @return void
     */
    public function executeSql($sql, array $params = [], array $types = [])
    {
        try {
            if (count($params) > 0) {
                $query = $this->acceso->prepare($sql);

                if (count($types) > 0) {
                    $result = $query->execute();
                } else {
                    $result = $query->execute($params);
                }
                return $result;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
