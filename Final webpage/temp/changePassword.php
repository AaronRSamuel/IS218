<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Password Change</title>
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
        .formone{
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
                        <a class="nav-link" href="changeUsername.php">Change Username<span class="sr-only"></span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<div class="formone">
<h2><b><u>Change Password:</u></b></h2>
  <div><?php if (isset($message)) {
          echo $message;
        } ?></div>
  <form method="post" action="" align="center">
    Current email:<br>
    <input type="text" name="email"><span id="email" class="required"></span>
    <br>
    Current Password:<br>
    <input type="password" name="currentPassword"><span id="currentPassword" class="required"></span>
    <br>
    New Password:<br>
    <input type="password" name="newPassword"><span id="newPassword" class="required"></span>
    <br>
    Confirm Password:<br>
    <input type="password" name="confirmPassword"><span id="confirmPassword" class="required"></span>
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
if (isset($_POST["newPassword"])) {
  session_start();
  $email = $_POST["email"]; /* Current email */
  $currentPassword = $_POST["currentPassword"];/* current user Password */
  $newPassword = $_POST["newPassword"];/* new user Password */
  $confirmPassword = $_POST["confirmPassword"];/* confirm new user Password */
require("./configure.php");
$connection_string = "mysql:host=$hostname;dbname=$project;charset=utf8mb4";

function password_validator($password)
{
$error = "";

if (strlen($password) < 8) { $error .="Password too short!
      " ; } if (strlen($password)> 29) {
  $error .= "Password too long!
  ";
  }
  if (!preg_match("#[0-9]+#", $password)) {
  $error .= "Password must include at least one number!
  ";
  }
  if (!preg_match("#[a-z]+#", $password)) {
  $error .= "Password must include at least one letter!
  ";
  }
  if (!preg_match("#[A-Z]+#", $password)) {
  $error .= "Password must include at least one CAPS!
  ";
  }
  return $error;
  }

  try {
  //setup db
  $db = new PDO($connection_string, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //check if email already exists
  $stmt = $db->prepare("SELECT * FROM users where email=:email");
  $stmt->execute(["email" => $email]);
  // and somewhere later:
  $user = $stmt->fetch();
  if (!$user) {
  echo "No user found. Please sign up before updating your password<br>";
  exit();
  }
  if ($result = password_validator($newPassword)) {
  echo $result;
  exit();
  }
  $old_hash = $user["password"];
  if (!password_verify($currentPassword, $old_hash)) {
  echo "Current Password does not match. Please try again.";
  exit();
  }
  if ($newPassword !== $confirmPassword) {
  echo "New and confirm password does not match. Try again.";
  exit();
  }
  if(password_verify($newPassword, $old_hash)) {
  exit('Sorry can\'t use the same password twice');
  }
  $sql = "UPDATE users SET password=:password where email=:email";
  $stmt = $db->prepare($sql);
  $stmt->execute(["password" => password_hash($newPassword, PASSWORD_BCRYPT), "email" => $email]);
  if ($stmt) {
  echo "Password successfully updated.";
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