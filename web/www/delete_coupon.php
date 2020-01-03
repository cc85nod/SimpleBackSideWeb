<?php

require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $couponId = $_POST['couponId'];
    $mysql = openMysql();
    $sql = "UPDATE coupon SET deletion=1 WHERE id=?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param('i', $couponId);
    $stmt->execute();
    $stmt->close();
    closeMysql($mysql);
}
