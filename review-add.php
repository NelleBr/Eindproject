<?php
session_start();

header("Content-Type: application/json");

include_once(__DIR__ . "/db.inc.php");
include_once(__DIR__ . "/classes/order.php");
include_once(__DIR__ . "/classes/review.php");

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo json_encode(["ok" => false, "error" => "Je moet ingelogd zijn."]);
    exit;
}

$userId = (int)$_SESSION["user_id"];

$productId = $_POST["product_id"] ?? "";
$rating = $_POST["rating"] ?? "";
$comment = trim($_POST["comment"] ?? "");

if (!is_numeric($productId)) {
    echo json_encode(["ok" => false, "error" => "Ongeldig product."]);
    exit;
}

$productId = (int)$productId;

if ($rating !== "" && (!is_numeric($rating) || (int)$rating < 1 || (int)$rating > 5)) {
    echo json_encode(["ok" => false, "error" => "Rating moet tussen 1 en 5 zijn."]);
    exit;
}

if ($comment === "" && $rating === "") {
    echo json_encode(["ok" => false, "error" => "Geef een rating of schrijf een comment."]);
    exit;
}

$orderClass = new Order();
$canReview = $orderClass->userBoughtProduct($conn, $userId, $productId);

if (!$canReview) {
    echo json_encode(["ok" => false, "error" => "Je kan enkel reviewen als je dit product gekocht hebt."]);
    exit;
}

$reviewClass = new Review();
$reviewId = $reviewClass->add($conn, $userId, $productId, $rating, $comment);

echo json_encode([
    "ok" => true,
    "review" => [
        "id" => (int)$reviewId,
        "user_name" => $_SESSION["first_name"] . " " . $_SESSION["last_name"],
        "rating" => ($rating === "" ? null : (int)$rating),
        "comment" => $comment,
        "created_at" => date("Y-m-d H:i")
    ]
]);
exit;
