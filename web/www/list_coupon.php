<?php

require_once "connection.php";

function listCoupon($kind)
{
    session_start();
    if (isset($_SESSION['ID']) || $kind == "all") {
        require_once "connection.php";
        $storeId = $_SESSION['ID'];

        $mysql = openMysql();
        if ($kind == "all") {
            $sql = "SELECT * FROM coupon";
            $stmt = $mysql->prepare($sql);
        } elseif ($kind == "me") {
            $sql = "SELECT * FROM coupon WHERE store_id=?";
            $stmt = $mysql->prepare($sql);
            $stmt->bind_param("i", $storeId);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            if($row['deletion'] == 1) continue;
            if ($kind == "all") {
                $storeId = $row['store_id'];
                $sql = "SELECT name FROM store_info WHERE id=?";
                $stmt = $mysql->prepare($sql);
                $stmt->bind_param("i", $storeId);
                $stmt->execute();
                $result2 = $stmt->get_result();
                $row2 = $result2->fetch_assoc();
                $name = $row2['name'];
            }
            if ($row['startTime'] == "00:00:00" && $row['endTime'] == "24:00:00") {
                $dayContent = "<td>全天</td>";
            } else {
                $startTime = date('G:i', strtotime($row["startTime"]));
                $endTime = date('G:i', strtotime($row["endTime"]));
                $dayContent = "<td>{$startTime}~{$endTime}</td>";
            }
            $weekday = explode(',', $row['weekday']);
            for ($i = 0; $i < sizeof($weekday); $i++) {
                if ($weekday[$i] == '0') {
                    $weekday = "每天";
                    break;
                }
                switch ($weekday[$i]) {
                case '1':
                    $weekday[$i] = "一";
                    break;
                case '2':
                    $weekday[$i] = "二";
                    break;
                case '3':
                    $weekday[$i] = "三";
                    break;
                case '4':
                    $weekday[$i] = "四";
                    break;
                case '5':
                    $weekday[$i] = "五";
                    break;
                case '6':
                    $weekday[$i] = "六";
                    break;
                case '7':
                    $weekday[$i] = "日";
                    break;
                }
            }
            if ($weekday !== "每天") {
                $weekday = implode(',', $weekday);
            }
            if ($row["useinterval"] == "0") {
                $userinterval = "無限制";
            } else {
                $userinterval = $row["useinterval"]."小時";
            }
            $startDate = str_replace('-', '/', $row["startDate"]);
            $endDate = str_replace('-', '/', $row["endDate"]);
            $elementId = $row['id'];
            if ($kind == "all") {
                if ($row['visible']) {
                    $visible = "已發布";
                } else {
                    $visible = "尚未發布";
                }
            } else {
                if ($row['visible']) {
                    $visible = '<td><button class="btn btn-warning hide" id="'."$elementId".'">顯示</button></td>';
                } else {
                    $visible = '<td><button class="btn btn-success hide" id='."$elementId".'">隱藏</button></td>';
                }
            }

            if ($kind == "all") {
                $doc = <<< EndDoc
                <tr>
                <td>{$name}</td>
                <td>{$startDate}</td>
                <td>{$endDate}</td>
                <td>{$weekday}</td>
                <td>{$userinterval}</td>
                {$dayContent}
                <td>{$row["content"]}</td>
                <td>{$visible}</td>
                </tr>
                EndDoc;
            } else {
                $doc = <<< EndDoc
                <tr>
                <td>{$startDate}</td>
                <td>{$endDate}</td>
                <td>{$weekday}</td>
                <td>{$userinterval}</td>
                {$dayContent}
                <td>{$row["content"]}</td>
                <td>{$row["authcode"]}</td>
                {$visible}
                <td><button class="btn btn-info" id="edit">編輯</button>
                <button class="btn btn-danger delete" id="{$elementId}">刪除</button></td>
                </tr>
                EndDoc;
            }
            // var couponId = this.id;
            echo $doc;
        }
    }
}
