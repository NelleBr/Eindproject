<?php

class Product
{
    public function getAll($conn)
    {
        $list = $conn->query("
            SELECT 
                products.id,
                products.name,
                products.description,
                products.price,
                products.stock,
                categories.name AS category_name,
                product_images.image_path AS image
            FROM products
            JOIN categories ON products.category_id = categories.id
            LEFT JOIN product_images ON product_images.product_id = products.id
            ORDER BY products.id DESC
        ");

        return $list->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($conn, $id)
    {
        $statement = $conn->prepare("
            SELECT 
                products.id,
                products.name,
                products.description,
                products.price,
                products.stock,
                categories.name AS category_name,
                product_images.image_path AS image
            FROM products
            JOIN categories ON products.category_id = categories.id
            LEFT JOIN product_images ON product_images.product_id = products.id
            WHERE products.id = :id
            LIMIT 1
        ");

        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function searchAndFilter($conn, $categoryFilter, $search)
    {
        // zelfde logica als jij nu gebruikt
        if ($categoryFilter === "" && $search === "") {
            $list = $conn->query("
                SELECT 
                    products.id,
                    products.name,
                    products.price,
                    categories.name AS category_name,
                    product_images.image_path AS image
                FROM products
                JOIN categories ON products.category_id = categories.id
                LEFT JOIN product_images ON product_images.product_id = products.id
                ORDER BY products.id DESC
            ");
            return $list->fetchAll(PDO::FETCH_ASSOC);
        }

        $sql = "
            SELECT 
                products.id,
                products.name,
                products.price,
                categories.name AS category_name,
                product_images.image_path AS image
            FROM products
            JOIN categories ON products.category_id = categories.id
            LEFT JOIN product_images ON product_images.product_id = products.id
            WHERE 1=1
        ";

        if ($categoryFilter !== "") {
            $sql .= " AND products.category_id = :category_id ";
        }

        if ($search !== "") {
            $sql .= " AND (products.name LIKE :search OR products.description LIKE :search) ";
        }

        $sql .= " ORDER BY products.id DESC ";

        $list = $conn->prepare($sql);

        if ($categoryFilter !== "") {
            $list->bindValue(":category_id", $categoryFilter);
        }

        if ($search !== "") {
            $list->bindValue(":search", "%" . $search . "%");
        }

        $list->execute();

        return $list->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($conn, $categoryId, $name, $description, $price, $stock)
    {
        $statement = $conn->prepare("
            INSERT INTO products (category_id, name, description, price, stock)
            VALUES (:category_id, :name, :description, :price, :stock)
        ");

        $statement->bindValue(":category_id", $categoryId);
        $statement->bindValue(":name", $name);
        $statement->bindValue(":description", $description);
        $statement->bindValue(":price", $price);
        $statement->bindValue(":stock", $stock);

        $statement->execute();

        return $conn->lastInsertId();
    }

    public function addImage($conn, $productId, $imagePath)
    {
        $imgStatement = $conn->prepare("
            INSERT INTO product_images (product_id, image_path)
            VALUES (:product_id, :image_path)
        ");

        $imgStatement->bindValue(":product_id", $productId);
        $imgStatement->bindValue(":image_path", $imagePath);
        $imgStatement->execute();
    }
}
