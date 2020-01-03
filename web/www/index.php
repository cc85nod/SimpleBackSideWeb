<?php
  session_start();
  require_once "session.php";
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
  <script src="/assets/js/core/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
        <div class="container-fluid">
            <div class="row">
              <!-- start row -->
              <div class="col-lg-12 col-md-12">
                <div class="card">
                <!-- start card -->
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">我的優惠券</h4>
                  </div>
                  <!-- content -->
                  <script>
                  $(function() {
                    $(".delete").click(function() {
                      var couponId = this.id;
                      var $tr = $(this).closest('tr');
                      $("#dialog").dialog({
                        modal: true,
                        height: 255,
                        width: 300,
                        resizable: false,
                        buttons: {
                          "Yes": function() {
                            $(this).dialog("close");
                            $.ajax({
                              type: "POST", // HTTP method POST or GET
                              url: "delete_coupon.php", //Where to make Ajax calls
                              dataType:"text", // Data type, HTML, json etc.
                              data:{
                                'couponId': couponId,
                              },
                              success:function(response){
                                $tr.find('td').fadeOut(500, function(){ 
                                    $tr.remove();                    
                                });
                              },
                              error:function (xhr, ajaxOptions, thrownError){
                                alert(thrownError);
                              }
                            })
                          },
                          "no": function() {
                            $(this).dialog("close");
                          }
                        }
                      })
                    });

                    $(".hide").click(function() {
                      var couponId = this.id;
                      var $btn = $(this);
                      var $td = $(this).closest('td');
                      $("#dialog").dialog({
                        modal: true,
                        height: 255,
                        width: 300,
                        resizable: false,
                        buttons: {
                          "Yes": function() {
                            $(this).dialog("close");
                            $.ajax({
                              type: "POST", // HTTP method POST or GET
                              url: "hide_coupon.php", //Where to make Ajax calls
                              dataType:"text", // Data type, HTML, json etc.
                              data:{
                                'couponId': couponId,
                              },
                              success:function(response){
                                if($btn.hasClass('btn-warning')) {
                                  $btn.removeClass('btn-warning');
                                  $btn.addClass('btn-success');
                                  $btn.text('隱藏');
                                } else {
                                  $btn.removeClass('btn-success');
                                  $btn.addClass('btn-warning');
                                  $btn.text('顯示'); 
                                }
                              },
                              error:function (xhr, ajaxOptions, thrownError){
                                alert(thrownError);
                              }
                            })
                          },
                          "no": function() {
                            $(this).dialog("close");
                          }
                        }
                      })
                    })
                  });
                  </script>
                  <div class="card-body table-responsive">
                    <table class="table table-hover">
                      <thead class="text-warning">
                        <th>開始日</th>
                        <th>結束日</th>
                        <th>星期</th>
                        <th>使用間隔</th>
                        <th>優惠時間</th>
                        <th>優惠內容</th>
                        <th>驗證碼</th>
                        <th>發布</th>
                        <th>編輯</th>
                      </thead>
                      <tbody>
                      <?php
                        require_once "list_coupon.php";
                        listCoupon("me");
                      ?>
                      </tbody>
                        
                    </table>
                  </div>

                <!-- end card -->
                </div>
              </div>
              <!-- end row -->
            </div>


            <div class="row">
              <!-- start row -->
              <div class="col-lg-12 col-md-12">
                <div class="card">
                <!-- start card -->
                  <div class="card-header card-header-tabs card-header-warning">
                    <h4 class="card-title">所有店家優惠券</h4>
                  </div>
                  <!-- content -->

                  <div class="card-body table-responsive">
                    <table class="table table-hover">
                      <thead class="text-warning">
                        <th>店家名稱</th>
                        <th>開始日</th>
                        <th>結束日</th>
                        <th>星期</th>
                        <th>使用間隔</th>
                        <th>優惠時間</th>
                        <th>優惠內容</th>
                        <th>發布</th>
                      </thead>
                      <tbody>
                      <?php
                        require_once "list_coupon.php";
                        listCoupon("all");
                      ?>                        
                      </tbody>
                    </table>
                  </div>

                <!-- end card -->
                </div>
              </div>
              <!-- end row -->
            </div>
        </div>
    </div>
    <div id="dialog"></div>
  </body>

  </html>