<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Username Change</title>
    <style>
        .navbar-brand{
            margin: 0;
            padding: 0;
        }

        .logo {
            height: 50px;
            padding-right: 15px;
            padding-left: 5px;
        }
        body{
            background-color: #E9F690;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            text-align: center;
        }
        .bg-light{
            background-color: tan !important;
        }
        .navbar-light{
            background-color: tan !important;
        }
        h2{
            font-family: "Papyrus", Times, serif;
            color: tan;
        }
        .formtwo{
            padding-top: 50px;
        }
        .button{
            background-color: tan;
            color: black;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row no-gutters">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: tan;">
            <a class="navbar-brand" href="#"><img src="https://image.flaticon.com/icons/svg/56/56906.svg" class="image-responsive logo" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="Login.php">Login<span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="changePassword.php">Change Password<span class="sr-only"></span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<div class="formtwo">
    <h2><b><u>Change Username:</u></b></h2>
  <form method="post" action="" align="center">
    New Username:<br>
    <input type="text" name="newUsername"><span id="newUsername" class="required"></span>
    <br>
    Current email:<br>
    <input type="text" name="email"><span id="email" class="required"></span>
    <br>
    Password:<br>
    <input type="password" name="password"><span id="password" class="required"></span>
    <br><br>
    <input type="submit" class="button">
  </form>
</div>
  <br>
  <br>
  <!-- jQuery, Popper.js, and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
</html>
<?php
if (isset($_POST["password"])) {
  session_start();
  $newUsername = $_POST["newUsername"];/* new username */
  $email = $_POST["email"]; /* Current email */
  $userPassword = $_POST["password"];/* confirm user Password */
  require("config.php");
  $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";

  $error = "";
  function validate_username($username,&$error){
      if(preg_match("/[@=_'\-+,<>]/",$username)){
          $error.= "Username contains invalid characters.";
          return 0;
      }else if (strpos($username,"..")){
          $error.="Username Can not contain consecutive periods.";
          return 0;
      }else if (strpos($username,".",-1)){
          $error.="Username Can not end with a period.";
          return 0;
      }
      return 1;
  }

  try {
    //check if the new username meets the requirements
    if(!validate_username($newUsername,$error)){
        echo $error;
        exit();
    }
    //setup db
    $db = new PDO($connection_string, $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //check if email already exists
    $stmt = $db->prepare("SELECT * FROM users where username=:username");
    $stmt->execute(["username" => $newUsername]);
    $user = $stmt->fetch();
    if ($user) {
      echo "Username already exist so try new unique username.<br>";
      exit();
    }
    $stmt = $db->prepare("SELECT * FROM users where email=:email");
    $stmt->execute(["email" => $email]);
    $user = $stmt->fetch();
    $password_hash = $user["password"];
    if (!password_verify($userPassword, $password_hash)) {
      echo "Password is incorrect.";
      exit();
    }
    $sql = "UPDATE users SET username=:username where email=:email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["username" => $newUsername, "email" => $email]);
    if ($stmt) {
      echo "Username successfully updated.";
      exit();
    } else {
      echo "Something went wrong. Please try again.";
      exit();
    }
  } catch (Exception $e) {
    echo $e->getMessage();
    exit();
  }
}
  ?>
