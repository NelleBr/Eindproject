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
}
