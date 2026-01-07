<?php

class Cart
{
    public function __construct()
    {
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }
    }

    public function getItems()
    {
        return $_SESSION["cart"];
    }

    public function isEmpty()
    {
        return count($_SESSION["cart"]) === 0;
    }

    public function add($productId)
    {
        $productId = (int)$productId;

        if (!isset($_SESSION["cart"][$productId])) {
            $_SESSION["cart"][$productId] = 1;
        } else {
            $_SESSION["cart"][$productId]++;
        }
    }

    public function getLines($conn, $productClass)
    {
        $lines = [];

        foreach ($this->getItems() as $productId => $qty) {
            $product = $productClass->getById($conn, $productId);
            if (!$product) {
                continue;
            }

            $lineTotal = $product["price"] * $qty;

            $lines[] = [
                "product" => $product,
                "qty" => $qty,
                "line_total" => $lineTotal
            ];
        }

        return $lines;
    }

    public function getTotal($lines)
    {
        $total = 0;
        foreach ($lines as $line) {
            $total += $line["line_total"];
        }
        return $total;
    }

    public function remove($productId)
    {
        $productId = (int)$productId;

        if (isset($_SESSION["cart"][$productId])) {
            unset($_SESSION["cart"][$productId]);
        }
    }

    public function clear()
    {
        $_SESSION["cart"] = [];
    }

    public function increase($productId)
    {
        $productId = (int)$productId;

        if (isset($_SESSION["cart"][$productId])) {
            $_SESSION["cart"][$productId]++;
        }
    }

    public function decrease($productId)
    {
        $productId = (int)$productId;

        if (isset($_SESSION["cart"][$productId])) {
            $_SESSION["cart"][$productId]--;

            if ($_SESSION["cart"][$productId] <= 0) {
                unset($_SESSION["cart"][$productId]);
            }
        }
    }
}
