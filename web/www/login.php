<?php 
session_start();

if(isset($_SESSION['ID'])) {
  echo '<script type="text/javascript">';
  echo 'alert("You have logged in.");';
  echo 'window.location.href="home"';
  echo '</script>';
}

require_once "connection.php";
require_once "session.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user = $password = $confirm_password = "";
  
  if (empty(trim($_POST['user']))) {
      $error = "Please enter your name";
  } else {
      $password = $_POST['password'];
      $user = $_POST['user'];
      
      $mysql = openMysql();
      $sql = "SELECT * FROM store_info WHERE password=? and name=?";
      $stmt = $mysql->prepare($sql);
      // if(!$stmt) {
      //     var_dump($mysql->error_list);
      // }
      // ss => string&string
      $stmt->bind_param("ss", $password, $user);
      $stmt->execute();
      $result = $stmt->get_result();
      // $result->fetch_assoc() => array, fetch_value => single
      // isset for variable, empty for value
      $stmt->close();
      closeMysql($mysql);
      
      if (!$result->num_rows) {
        $error = "failed to login";
      } else {
        $result = $result->fetch_array();
        $_SESSION['ID'] = $result['id'];
        header('Location:home');
      }
    }
  }
?>

<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <title>中央大學特約商店後台管理系統</title>
  <style type="text/css">
    .wrapper {    
      margin-top: 150px;
      margin-bottom: 20px;
    }

    body{
      background-size: 100% auto;
    }

    .form-signin {
      max-width: 420px;
      padding: 30px 38px 66px;
      margin: 0 auto;
      background-color: rgba(254,254,254,0.7);
      border: 3px   rgba(0,0,0,0.1);
      border-radius:10px;  
    }

    .form-signin-heading {
      text-align:center;
      margin-bottom: 30px;
    }

    .form-control {
      position: relative;
      font-size: 16px;
      height: auto;
      padding: 10px;
    }

    input[type="text"] {
      margin-bottom: 0px;
      border-bottom-left-radius: 0;
      border-bottom-right-radius: 0;
    }

    input[type="password"] {
      margin-bottom: 20px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }

    .colorgraph {
      height: 7px;
      border-top: 0;
      background: #c4e17f;
      border-radius: 5px;
      background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
      background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
      background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
      background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
    }

    @font-face {
      font-family: '/65B0/7EC6/660E/4F53';
      font-style: normal;
      font-weight: 500;
    }
    h1,h2,h3,h4,h5,h6,p,a,div{
      font-family: '/65B0/7EC6/660E/4F53', serif;
    }

  </style>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body style="background-color: #1a2035">
  <div class="container">
    <div class="wrapper">
      <form class="form-signin" action="login.php" method="POST">
        <h3 class="form-signin-heading inline"><i class="glyphicon glyphicon-cog"></i> 中央大學特約商店後台<br>管理系統</h3>
        <hr class="colorgraph"><br>
        <?php 
          if($error !== "") echo '<script type="text/javascript">alert("'.$error.'");</script>';
        ?>
        <input class="form-control" placeholder="帳號" name="user" required="" autofocus="" type="text">
        <input class="form-control" placeholder="密碼" name="password" required="" type="password">           
        <button class="btn btn-lg btn-primary btn-block" type="Submit">登入</button>
      </form>
    </div>
  </div>
</body>
</html>