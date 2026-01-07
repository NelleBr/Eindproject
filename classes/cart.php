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
}
