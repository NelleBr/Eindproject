<?php
class Category
{
    public function getAll($conn)
    {
        $statement = $conn->query("
            SELECT id, name
            FROM categories
            ORDER BY name
        ");

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($conn, $name)
    {
        $statement = $conn->prepare("
            INSERT INTO categories (name)
            VALUES (:name)
        ");

        $statement->bindValue(":name", $name);
        $statement->execute();
    }
}
