<?php
session_start();

require_once "connection.php";
require_once "session.php";

if (!isset($_SESSION['ID'])) {
    echo '<script type="text/javascript">';
    echo 'alert("You are not logged in.");';
    echo 'window.location.href="home"';
    echo '</script>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $storeId = $_SESSION['ID'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $hours = $_POST['hours'];
    $phone = $_POST['phone'];
    $description = $_POST['description'];
  
    if (isset($_POST['submit'])) {
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            $image = $_FILES['image']['tmp_name'];
            $path = 'images/'.$_FILES['image']['name'];
            // if(!move_uploaded_file($image, $path)) {
          //     echo "Upload failed";
          // }
        }
    }
    $mysql = openMysql();
    $sql = "UPDATE store_info SET name=?, pic_path=?, password=?,
          phone=?, description=?, hours=? WHERE id=?";
    $stmt = $mysql->prepare($sql);
    // if(!$stmt) {
    //     var_dump($mysql->error_list);
    // }
    $stmt->bind_param(
      "ssssssi",
      $name,
      $path,
      $password,
      $phone,
      $description,
      $hours,
      $storeId
  );
    $stmt->execute();
    $stmt->close();
    closeMysql($mysql);

    echo '<script type="text/javascript">';
    echo 'alert("Modify successfully!");';
    echo '</script>';
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
            <h1 style="color: white">店家資訊</h1>
          </div>
        </div>
      </nav>

      <div class="content">
        <!-- start of content -->
        <div class="container-fluid">
            <div class="row">
              <!-- start row -->
              <div class="col-lg-12 col-md-12">
                <form action="setting.php" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label >修改密碼</label>
                    <input class="form-control" value="123456789" name="password">
                  </div>

                  <div class="form-group">
                    <label >店家名稱</label>
                    <input class="form-control" value="中大食堂" name="name">
                  </div>

                  <div class="form-group">
                    <label >連絡電話</label>
                    <input class="form-control" value="0975123123" name="phone">
                  </div>

                  <div class="form-group">
                    <label>營業時間</label>
                    <textarea class="form-control" name="hours">周一到周五 10:00-12:00
周一到周五 10:00-12:00</textarea>
                  </div>

                  <div class="form-group">
                    <label >店家介紹</label>
                    <textarea class="form-control" name="description">中大食堂好好吃
中大食堂好好吃</textarea>
                  </div>

                  <div class="form-group">
                      <label>店家照片</label>
                        <div class="input-group">
                          <span class="input-group-btn">
                            <label>
                            <span class="btn btn-default btn-file">
                              
                              選擇照片 <input type="file" id="imgInp" name="image" style="display: none;">
                              
                            </span>
                            </label>
                          </span>
                          <input type="text" class="form-control" style="color: black" readonly>
                        </div>
                      <label> 請上傳長寬相同之照片</label>
                      <br>
                       <img id='img-upload'/>
                  </div>
                  <button type="submit" name='submit' class="btn btn-primary">更新資料</button>
                </form>
              </div>
              <!-- end row -->
            </div>
        </div>
        <!-- end of content -->
      </div>
    </div>


<script src=" https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
    $(document).ready( function() {
      $(document).on('change', '.btn-file :file', function() {
    var input = $(this),
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [label]);
    });

    $('.btn-file :file').on('fileselect', function(event, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = label;
        
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
      
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#img-upload').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){
        readURL(this);
    });   
  });
  </script>

  <style type="text/css">
    .btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

#img-upload{
    width: 120px;
    height: 120px;
}
  </style>

  </body>

  </html>