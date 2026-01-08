<?php

class Order
{
    public function create($conn, $userId, $totalPrice)
    {
        $stmt = $conn->prepare("
            INSERT INTO orders (user_id, total_price, created_at)
            VALUES (:user_id, :total_price, NOW())
        ");
        $stmt->bindValue(":user_id", (int)$userId, PDO::PARAM_INT);
        $stmt->bindValue(":total_price", $totalPrice);
        $stmt->execute();

        return $conn->lastInsertId();
    }

    public function addItem($conn, $orderId, $productId, $quantity, $priceEach)
    {
        $stmt = $conn->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price_each)
            VALUES (:order_id, :product_id, :quantity, :price_each)
        ");
        $stmt->bindValue(":order_id", (int)$orderId, PDO::PARAM_INT);
        $stmt->bindValue(":product_id", (int)$productId, PDO::PARAM_INT);
        $stmt->bindValue(":quantity", (int)$quantity, PDO::PARAM_INT);
        $stmt->bindValue(":price_each", $priceEach);
        $stmt->execute();
    }

    public function getByUserId($conn, $userId)
    {
        $statement = $conn->prepare("
            SELECT id, user_id, total_price, created_at
            FROM orders
            WHERE user_id = :user_id
            ORDER BY created_at DESC, id DESC
        ");
        $statement->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItemsByOrderId($conn, $orderId)
    {
        $statement = $conn->prepare("
        SELECT 
            order_items.product_id,
            order_items.quantity,
            order_items.price_each,
            products.name AS product_name,
            (
                SELECT product_images.image_path
                FROM product_images
                WHERE product_images.product_id = products.id
                ORDER BY product_images.id ASC
                LIMIT 1
            ) AS image
        FROM order_items
        JOIN products ON products.id = order_items.product_id
        WHERE order_items.order_id = :order_id
        ORDER BY order_items.id ASC
    ");
        $statement->bindValue(":order_id", (int)$orderId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function userBoughtProduct($conn, $userId, $productId)
    {
        $stmt = $conn->prepare("
        SELECT 1
        FROM orders
        JOIN order_items ON order_items.order_id = orders.id
        WHERE orders.user_id = :user_id
          AND order_items.product_id = :product_id
        LIMIT 1
    ");
        $stmt->bindValue(":user_id", (int)$userId, PDO::PARAM_INT);
        $stmt->bindValue(":product_id", (int)$productId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() ? true : false;
    }
}
