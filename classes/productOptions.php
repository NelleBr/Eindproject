<?php

class ProductOption
{
    public function getByProductId($conn, $productId)
    {
        $statement = $conn->prepare("
            SELECT option_name, option_value
            FROM product_options
            WHERE product_id = :product_id
            ORDER BY id ASC
        ");
        $statement->bindValue(":product_id", $productId);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}