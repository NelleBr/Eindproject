<?php

class Review
{
    public function add($conn, $userId, $productId, $rating, $comment)
    {
        $stmt = $conn->prepare("
            INSERT INTO reviews (user_id, product_id, rating, comment, created_at)
            VALUES (:user_id, :product_id, :rating, :comment, NOW())
        ");

        $stmt->bindValue(":user_id", (int)$userId, PDO::PARAM_INT);
        $stmt->bindValue(":product_id", (int)$productId, PDO::PARAM_INT);

        if ($rating === "" || $rating === null) {
            $stmt->bindValue(":rating", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":rating", (int)$rating, PDO::PARAM_INT);
        }

        $stmt->bindValue(":comment", $comment);

        $stmt->execute();

        return $conn->lastInsertId();
    }

    public function getByProductId($conn, $productId)
    {
        $stmt = $conn->prepare("
            SELECT 
                reviews.id,
                reviews.rating,
                reviews.comment,
                reviews.created_at,
                users.first_name,
                users.last_name
            FROM reviews
            JOIN users ON users.id = reviews.user_id
            WHERE reviews.product_id = :product_id
            ORDER BY reviews.created_at DESC, reviews.id DESC
        ");
        $stmt->bindValue(":product_id", (int)$productId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
