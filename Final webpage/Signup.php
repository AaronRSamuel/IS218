<html>
        <head>
                <title>SamsBakery - Register</title>
                <style>
		                body{
			                   background-color: black;
  			                 background-image: url('https://buffer.com/library/content/images/library/wp-content/uploads/2016/06/giphy.gif');
                         height: 100%;
                         background-position: center;
                         background-repeat: no-repeat;
                         background-size: cover;
                         color: white;
		                     }
		           </style>
               <script>
                        function verifyEmail(form){
                                let ee = document.getElementById("email_error");
                                if(form.email.value.trim().length == 0){
                                        ee.innerText= "please enter correct email";
                                        return false;
                                }
                                else{
                                        ee.innerText = " ";
                                        return true;
                                }
                        }
                        function findFormsOnLand(){
                                let myForm = document.forms.regform;
                                let mySameForm = document.getelementById("myForm");
                                console.log("Form by name", myForm);
                                console.log("Form by id", mySameForm);
                        }
                        function verifyPasswords(form){
                                let pe = document.getElementById("password_error");
                                if(form.password.value != form.confirm.value){
                                        //alert("made a typo");
                                        pe.innerText = "Password doesnt match try again";
                                        return false;
                                }
                                pe.innerText= "";
                                return true;
                        }
                </script>
        </head>
        <body>
                <form name="regform" id="myForm" method="POST" onsubmit="return doValidations(this)">

                        <font size="6">
                        <div>
                                <lable for="email"> Email: </lable>
                                <input type="email" name="email" placeholder = Email email/>
                                <span id="email_error"></span>
                        </div>
                        <div>
                                <lable for="username"> Username: </lable>
                                <input type="text" name="username" placeholder = Username email/>
                        </div>
                        <div>
                                <lable for="password"> Password:<lable/>
                                <input type ="password" id="password" name= "password" placeholder = Password passowrd/>
                        </div>
                        <div>
                                <lable for ="conf"> Confirm Password:</lable>
                                <input type ="password" id= "conf" name="confirm" placeholder = Confirm passowrd/>
                        </div>
                        </font>
                        <div>
                                <di>&nbsp;</di>
                                <input type="submit" value="Register" style="height:50px; width:100px" />
                        </div>
            </form>
        </body>
</html>
<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(        isset($_POST['email'])
        && isset($_POST['username'])
        && isset($_POST['password'])
        && isset($_POST['confirm'])
        ){
        $email = $_POST['email'];
        $username = $_POST['username'];
        $pass = $_POST['password'];
        $conf = $_POST['confirm'];

        if(strpos($username, "&") === false){}
        else{
          echo "username contains an &";
          exit();
        }
        if(strpos($username, "=") === false){}
        else{
          echo "username contains an =";
          exit();
        }
        if(strpos($username, "_") === false){}
        else{
          echo "username contains an _";
          exit();
        }
        if(strpos($username, "<") === false){}
        else{
          echo "username contains an <";
          exit();
        }
        if(strpos($username, ">") === false){}
        else{
          echo "username contains an >";
          exit();
        }
        if(strpos($username, "+") === false){}
        else{
          echo "username contains an +";
          exit();
        }
        if(strpos($username, "-") === false){}
        else{
          echo "username contains an -";
          exit();
        }
        if(strpos($username, "..") === false){}
        else{
          echo "username contains more than one period in a row";
          exit();
        }
        if(strpos($username, ",") === false){}
        else{
          echo "username contains an ,";
          exit();
        }
        if(strpos($username, ".",-1) === false){}
        else{
          echo "username contains an '";
          exit();
        }
        if(strpos($username, ".",-1) === false){}
        else{
          echo "username ends with a period";
          exit();
        }
        try{
          if(strpos($username, ".") == 0){
            echo "username starts with a period";
            exit();
          }
        }
        if(strpos($email, ".com",-1) === false){}
        else{
          echo "email not valid";
          exit();
        }
        if($pass == $conf){}
        else{
          echo "passwords dont match";
          exit();
        }
        //let's hash it
        $pass = password_hash($pass, PASSWORD_BCRYPT);
        echo "<br>$pass<br>";
        //it's hashed
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try {
                //setup db
                $db = new PDO($connection_string, $dbuser, $dbpass);
                //check if email already exists
                $stmt = $db->prepare("SELECT email from `users` where email = :email");
                $params = array(":email"=> $email);
                $stmt->execute($params);
            		$result = $stmt->fetch(PDO::FETCH_ASSOC);
                if (mysql_num_rows($result)>0) {
                    echo "email already in use";
                    exit();
                }
                //check if username already exists
                $stmt = $db->prepare("SELECT username from `users` where username = :username");
                $params = array(":username"=> $username);
                $stmt->execute($params);
            		$result = $stmt->fetch(PDO::FETCH_ASSOC);
                if (mysql_num_rows($result)>0) {
                    echo "Username already in use";
                    exit();
                }
                //insert into users
                $stmt = $db->prepare("INSERT INTO `users`
                        (email, username, password) VALUES
                        (:email, :username, :password)");

        $params = array(":email"=> $email,":username"=> $username ":password"=> $pass);
        $stmt->execute($params);
        echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
        }
        catch(Exception $e){
                echo $e->getMessage();
                exit();
        }
}
?>
