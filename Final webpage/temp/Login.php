<?php
session_start();
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Login</title>
   </head>
   <style>
       body{
            background-color: black;
            background-image: url();
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            color: white;
            }
 					 .button {
               background-color: gray;
               border: none;
               color: white;
               padding: 15px 32px;
               text-align: center;
               text-decoration: none;
               display: inline-block;
               font-size: 16px;
             }
  </style>
  <header>
     <div align = "right">
       <button class = "button" onclick="location.href = 'https://web.njit.edu/~as3655/IS218/Final/Signup.php';"
     type="button" name="Register" > Register</button>
     </div>
  </header>
   <body>
     <div>
        <font size="6">
        <center> Welcome Back! </center><br>
    </div>

    <center><form name="loginform" id="myForm" method="POST">
      <label for="email">Username: </label>
      <input type="text" id="username" name="username" placeholder="Enter Username"/><br>
      <label for="pass">Password: </label>
      <input type="password" id="pass" name="password" placeholder="Enter password"/><br>
      <input type="submit" value="Login"/>
    </form></form>
   <button onclick="location.href = 'https://web.njit.edu/~as3655/IS218/Final/changePassword.php';"
   type="button" name="forgot" > forgot password</button>
  </center><br>
    <center><canvas id="canvas" width="400" height="400"
     style="background-color: black">
   </canvas></center>
    <script type="text/javascript">
       var canvas = document.getElementById("canvas");
       var ctx = canvas.getContext("2d");
       var radius = canvas.height / 2;
       ctx.translate(radius, radius);
       radius = radius * 0.90
       setInterval(drawClock, 1000);

       function drawClock() {
         drawFace(ctx, radius);
         drawNumbers(ctx, radius);
         drawTime(ctx, radius);
       }

       function drawFace(ctx, radius) {
         var grad;
         ctx.beginPath();
         ctx.arc(0, 0, radius, 0, 2*Math.PI);
         ctx.fillStyle = 'black';
         ctx.fill();
         grad = ctx.createRadialGradient(0,0,radius*0.95, 0,0,radius*1.05);
         grad.addColorStop(0, 'black');
         grad.addColorStop(0.5, 'black');
         grad.addColorStop(1, 'black');
         ctx.strokeStyle = grad;
         ctx.lineWidth = radius*0.1;
         ctx.stroke();
         ctx.beginPath();
         ctx.arc(0, 0, radius*0.1, 0, 2*Math.PI);
         ctx.fillStyle = 'black';
         ctx.fill();
       }

       function drawNumbers(ctx, radius) {
         var ang;
         var num;
         ctx.font = radius*0.15 + "px arial";
         ctx.fillStyle = "white"
         ctx.textBaseline="middle";
         ctx.textAlign="center";
         for(num = 1; num < 13; num++){
           ang = num * Math.PI / 6;
           ctx.rotate(ang);
           ctx.translate(0, -radius*0.85);
           ctx.rotate(-ang);
           ctx.fillText(num.toString(), 0, 0);
           ctx.rotate(ang);
           ctx.translate(0, radius*0.85);
           ctx.rotate(-ang);
         }
       }

       function drawTime(ctx, radius){
         var now = new Date();
         var hour = now.getHours();
         var minute = now.getMinutes();
         var second = now.getSeconds();
         //hour
         hour=hour%12;
         hour=(hour*Math.PI/6)+
         (minute*Math.PI/(6*60))+
         (second*Math.PI/(360*60));
         drawHand(ctx, hour, radius*0.5, radius*0.07);
         //minute
         minute=(minute*Math.PI/30)+(second*Math.PI/(30*60));
         drawHand(ctx, minute, radius*0.8, radius*0.07);
         // second
         second=(second*Math.PI/30);
         drawHand(ctx, second, radius*0.9, radius*0.02);
       }

       function drawHand(ctx, pos, length, width) {
         ctx.beginPath();
         ctx.lineWidth = width;
         ctx.lineCap = "round";
         ctx.fillStyle = "white"
         ctx.strokeStyle = "white"
         ctx.moveTo(0,0);
         ctx.rotate(pos);
         ctx.lineTo(0, -length);
         ctx.stroke();
         ctx.rotate(-pos);
       }
    </script>
   </body>
 </html>

<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])){
  	$pass = $_POST['password'];
  	$username = $_POST['username'];
    require("config.php");
    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
  try {
        $db = new PDO($connection_string, $dbuser, $dbpass);
        $stmt = $db->prepare("SELECT id, email, password from `users` where username = :username LIMIT 1");
        $params = array(":username"=> $username);
            $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
          $userpassword = $result['password'];
          if(password_verify($pass, $userpassword)){
            $id = $result['id'];
            $_SESSION['user'] = $username;
            $_SESSION['id'] = $id;
          }
          else{
              echo "Failed to login, invalid password";
              exit();
          }
        }
        else{
          echo "Invalid username";
          exit();
        }
  }
  catch(Exception $e){
    echo $e->getMessage();
    exit();
  }
  echo '<script type="text/javascript">
           window.location = "https://web.njit.edu/~as3655/IS218/Final/task.php"
      </script>';
}
 ?>
