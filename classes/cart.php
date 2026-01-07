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

}
