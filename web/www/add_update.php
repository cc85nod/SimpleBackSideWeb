<?php
session_start();

require_once "connection.php";
require_once "session.php";

$error = "";

if (!isset($_SESSION['ID'])) {
    echo '<script type="text/javascript">';
    echo 'alert("You are not logged in.");';
    echo 'window.location.href="home"';
    echo '</script>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $storeId = $_SESSION['ID'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $weekday = $_POST['weekday'];
    $content = $_POST['content'];
    $authcode = $_POST['authcode'];
    $useinterval = $_POST['useinterval'];

    $now = new DateTime();
    $startDate_time = new DateTime($startDate);
    $endDate_time = new DateTime($endDate);
    if ($startDate > $endDate || $now > $startDate_time) {
        $error = "Your date time setting is wrong.";
        die;
    }
    if (isset($_POST['allDay'])) {
        $startTime = '00:00:00';
        $endTime = '24:00:00';
    } else {
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
    }
    if ($weekday[0] == '0') {
        $weekday = '1,2,3,4,5,6,7';
    } else {
        $weekday = implode(',', $weekday);
    }
    $mysql = openMysql();
    $sql = "INSERT INTO coupon 
          (store_id, startDate, endDate, startTime, endTime, useinterval, weekday, 
          content, authcode) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysql->prepare($sql);
    // if(!$stmt) {
    //     var_dump($mysql->error_list);
    // }
    $stmt->bind_param(
        "issssisss",
        $storeId,
        $startDate,
        $endDate,
        $startTime,
        $endTime,
        $useinterval,
        $weekday,
        $content,
        $authcode
  );
    $stmt->execute();

    $stmt->close();
    closeMysql($mysql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    中央大學特約商店後台管理系統
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="dark-edition">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="black" data-image="assets/img/sidebar-2.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
      -->
      <div class="logo"><a class="simple-text logo-normal">
        填入店家名稱
      </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="home">
              <i class="material-icons">☢</i>
              <p>首頁</p>
            </a>
          </li>
        </ul>
        
        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="login.php">
              <i class="material-icons">♨</i>
              <p>登入</p>
            </a>
          </li>
        </ul>

        <script type="text/javascript">
        function logout() {
            if (confirm('Are you sure to logout')) {
                return true;
            }
            return false;
        };
        </script>

        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="./logout.php" onclick="return logout();">
              <i class="material-icons">🚲</i>
              <p>登出</p>
            </a>
          </li>
        </ul>

        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="./setting.php">
              <i class="material-icons">⚒</i>
              <p>店家設定</p>
            </a>
          </li>
        </ul>

        <!-- <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="./dashboard.html">
              <i class="material-icons">🧾</i>
              <p>優惠券列表</p>
            </a>
          </li>
        </ul> -->

        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="./add_update.php">
              <i class="material-icons">📤</i>
              <p>新增優惠券</p>
            </a>
          </li>
        </ul>

      </div>
    </div>
    
    <div class="main-panel">
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top " id="navigation-example">
        <div class="container-fluid">
          <div class="navbar-wrapper">
                <h1 style="color: white">新增優惠券</h1>
          </div>
        </div>
      </nav>

      <style type="text/css">
        .labelheader {
          font-size: 30px;
        }
      </style>

      <div class="content">
        <!-- start of content -->
        <div class="container-fluid">
            <div class="row">
              <!-- start row -->
              <div class="col-lg-12 col-md-12">
                <form method="POST" action="add_update.php">
                  <div class="form-group">
                    <label class="labelheader">開始日期</label>
                    <input type="date" name="startDate" class="form-control" style="width: auto;" required>
                  </div>

                  <div class="form-group">
                    <label class="labelheader">結束日期</label>
                    <input type="date" name="endDate" class="form-control" style="width: auto;" required>
                  </div>

                  <div class="form-group">
                    <label >星期</label>
                    <br>
                    <label class="form-control" style="width: auto;display: initial;">
                    <input type="checkbox" value="0" name="weekday[]">
                    不限
                    </label>
                    <label class="form-control" style="width: auto;display: initial;">
                    <input type="checkbox" value="1" name="weekday[]">
                    星期一
                    </label>
                    <label class="form-control" style="width: auto;display: initial;">
                    <input type="checkbox" value="2" name="weekday[]">
                    星期二
                    </label>
                    <label class="form-control" style="width: auto;display: initial;">
                    <input type="checkbox" value="3" name="weekday[]">
                    星期三
                    </label>
                    <label class="form-control" style="width: auto;display: initial;">
                    <input type="checkbox" value="4" name="weekday[]">
                    星期四
                    </label>
                    <label class="form-control" style="width: auto;display: initial;">
                    <input type="checkbox" value="5" name="weekday[]">
                    星期五
                    </label>
                    <label class="form-control" style="width: auto;display: initial;">
                    <input type="checkbox" value="6" name="weekday[]">
                    星期六
                    </label>
                    <label class="form-control" style="width: auto;display: initial;">
                    <input type="checkbox" value="7" name="weekday[]">
                    星期日
                    </label>
                  </div>

                  <div class="form-group">
                    <label class="labelheader">優惠時間</label>
                    <label class="form-control" style="width: auto;display: initial;">
                    <input type="checkbox" value="0" name="allDay" id="allDay" onchange="valueChanged()" >
                    全天
                    </label>
                    <script type="text/javascript">
                      function valueChanged() {
                        if(!document.getElementById('allDay').checked) {
                          document.getElementById('startTime').style.display = 'block';
                          document.getElementById('endTime').style.display = 'block';
                          document.getElementById('to').style.display = 'block';
                        } else {
                          document.getElementById('startTime').style.display = 'none';
                          document.getElementById('endTime').style.display = 'none';
                          document.getElementById('to').style.display = 'none';
                        }
                      }
                    </script>
                    <!-- 若選全天 disable 下面 -->
                    <input type="time" value="08:00" class="form-control" style="width: auto;" id="startTime" name="startTime">
                    <span style="color: white" id="to">&nbsp&nbsp&nbsp&nbsp到</span>
                    <input type="time" value="21:00" class="form-control" style="width: auto;" id="endTime" name="endTime">
                  </div>

                  <div class="form-group">
                    <label class="labelheader">使用間隔</label>
                    <br>
                    <input type="number" class="form-control" min="0" max="24" value="0" style="width: 40px;display: initial;text-align: right;" name="useinterval">
                    <span style="color: white">小時</span>
                  </div>

                  <div class="form-group">
                      <label class="labelheader">優惠內容</label>
                      <textarea class="form-control" placeholder="請詳細描述優惠項目及限制" name="content" required></textarea>
                  </div>

                  <div class="form-group">
                      <label class="labelheader">驗證碼</label>
                      <input class="form-control" placeholder="Default" name="authcode">
                  </div>
                  <br>
                  <span style="color: white">若優惠券正在優惠期間，更新會在次日生效</span>
                  <br>
                  <span style="color: white">發布前請再三確認</span>
                  <br>
                  <button type="submit" class="btn btn-primary">發布 或是 更新</button>
                </form>
              </div>
              <!-- end row -->
            </div>
        </div>
        <!-- end of content -->
      </div>
    </div>

  </body>

  </html>