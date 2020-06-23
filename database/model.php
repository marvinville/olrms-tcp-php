<?php
class DB_Model
{
    public function insert($table, $data, $db)
    {
        $fields = '';
        $values = '';

        foreach ($data as $key => $value) {

            $fields .= $key . ',';
            $values .= "'" . $value . "',";
        }

        $fields = substr($fields, 0, -1);
        $values = substr($values, 0, -1);

        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        return $db->exec($sql);
    }
    public function read($db, $table, $orderBy, $limit = false, $where = false,  $select = '*')
    {
        $sql = "SELECT $select FROM $table";
        $sql .= $where ? " WHERE " . $where : '';
        $sql .= $orderBy ? " ORDER BY " . $orderBy : '';
        $sql .= $limit ? " LIMIT " . $limit : '';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetchAll();
    }
}
