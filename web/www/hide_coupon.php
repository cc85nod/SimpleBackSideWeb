<?php

require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $couponId = $_POST['couponId'];
    $mysql = openMysql();
    $sql = "SELECT visible FROM coupon WHERE id=?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param('i', $couponId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if($row['visible'] == 1) {
        $sql = "UPDATE coupon SET visible=0 WHERE id=?";
    } else {
        $sql = "UPDATE coupon SET visible=1 WHERE id=?";
    }
    
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param('i', $couponId);
    $stmt->execute();

    $stmt->close();
    closeMysql($mysql);
}
