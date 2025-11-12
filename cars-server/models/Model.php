<?php
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";

   
    public static function getAllCars($data){
        $types="";
        foreach ($data as $key => $value) {
            if (gettype($value) == "string") {
                $types .= "s";
            } elseif (gettype($value) == "integer") {
                $types .= "i";
            } elseif (gettype($value) == "float" || gettype($value) == "double") {
                $types .= "d";
            }
        }
        
        return $types;
    }
    public static function find(mysqli $connection, string $id){//read
        $sql = sprintf("SELECT * from %s WHERE %s = ?",
        static::$table,
        static::$primary_key);
        $query = $connection->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();               
        $data = $query->get_result()->fetch_assoc();
        return $data ? new static($data) : null;
    }

    public static function findall(mysqli $connection){
        $sql = sprintf("SELECT * from %s",
        static::$table,
        static::$primary_key);
        $query = $connection->prepare($sql);
        $query->execute();               
        $data = $query->get_result()->fetch_assoc();
        return $data ? new static($data) : null;
    }

    public static function create(mysqli $connection, array $data){
        $columns = array_keys($data);
        $values = array_values($data);
        $placeholders = implode(',', array_fill(0, count($columns), '?'));
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            static::$table,
            implode(',', $columns),
            $placeholders);   
        $stmt = $connection->prepare($sql);     
        $types = '';
        foreach ($values as $value) {
            if (is_int($value)) $types .= 'i';
            elseif (is_float($value)) $types .= 'd';
            elseif (is_string($value)) $types .= 's';
            else $types .= 'b';}  
        $stmt->bind_param($types, ...$values);     
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public static function update(mysqli $connection, int $id, array $data){
        $columns = array_keys($data);
        $values = array_values($data);
        $set_clause = implode(' = ?, ', $columns) . ' = ?';
        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s = ?",
            static::$table,
            $set_clause,
            static::$primary_key);
        $stmt = $connection->prepare($sql);
        $types = '';

        foreach ($values as $value) {
            if (is_int($value)) $types .= 'i';
            elseif (is_float($value)) $types .= 'd';
            elseif (is_string($value)) $types .= 's';
            else $types .= 'b';
        }

        $types .= 'i';
        $values[] = $id;
        $stmt->bind_param($types, ...$values);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public static function delete(mysqli $connection, int $id){
        $sql = sprintf(
            "DELETE FROM %s WHERE %s = ?",
            static::$table,
            static::$primary_key
        );
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

}

?>