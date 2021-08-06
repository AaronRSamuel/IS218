<?php
session_start();
echo $_SESSION['id'];
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <title>
            IS 218 Calendar
        </title>
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
                            <a class="nav-link" href="signout.php">Logout<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="changeUsername.php">Change Username<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="changePassword.php">Change Password<span class="sr-only"></span></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <input type="submit" class = "button" name="display" value ="Display">
    <?php
    if(array_key_exists('display',$_POST)){
        DisplayTasks();
    }
    ?>
    <h2><u><b>Create an Event</b></u></h2>
    <div id="createevent"><form method ="POST">
            Event: <input type="text" name="eventname" value = "Enter Name here"><br>
            Date: <input type="datetime-local" name="eventdate"><br>
            Description: <input type="text" name="desc" value="Enter description here"><br>
            Urgency: <select name="urgency" id="prio">
                <option value="normal">normal</option>
                <option value="important">important</option>
                <option value="veryimportant">veryimportant</option>
            </select><br>
            <input type="submit" class="button" value="Create" name="createButton">
        </form>
    </div>

    <h2><u><b>Modify an Event</b></u></h2>
    <div id="Modifyevent"><form method ="post">
            Event ID: <input type="int" name="eventID"><br>
            Event: <input type="text" name="eventname" value = "Enter Name here"><br>
            Date: <input type="datetime-local" name="eventdate"><br>
            Description: <input type="text" name="desc" value="Enter description here"><br>
            Urgency: <select name="urgency" id="prio">
                <option value="normal">Normal</option>
                <option value="important">Important</option>
                <option value="veryimportant">Very important</option>
            </select><br>
            <input type="submit" class="button" value="Edit" name="modifyButton">
        </form>
    </div>
    <h2><u><b>Delete an Event</b></u></h2>
    <div id="Deleteevent"><form method ="post">
            Event ID: <input type="int" name="eventID"><br>
            <input type="submit" class="button" value="Delete" name="deleteButton">
        </form>
    </div>
    <h2><u><b>Update the status of an Event</b></u></h2>
    <div id="StateUpdate"><form method ="post">
            Event ID: <input type="int" name="eventID"><br>
            <label for="state">State:</label>
            <input type ="checkbox" id="state" name="statebox"><br>
            <input type="submit" class="button" value="Update" name="stateButton">
        </form>
    </div>
    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    </body>
    </html>
<?php

function DisplayTasks() {
    DisplayStates();
    $userid= $_SESSION['id'];
    try {
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $conn = new PDO($connection_string, $dbuser, $dbpass);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    echo "incomplete tasks:";
    $userid= $_SESSION['id'];
    $urgency= 'veryimportant';
    $query = $conn->prepare("SELECT * FROM `events` WHERE userid = :userid AND urgency = :urgency AND status = :status");
    $params = array(":userid"=>$userid, ":urgency"=>$urgency, ":status"=>00);
    $query->execute($params);
    $result = $query->fetchAll();
    $query->closeCursor();
    $start = date_create("Y.m.d h:i:sa");
    echo "<table>";
    foreach($result as $row){
        date_default_timezone_set('America/Los_Angeles');
        $start = new DateTime('now');
        $end = date_create($row['evt_start']);
        $diff = date_diff($start, $end);       
        echo "<tr>";
        echo "<td>".$row['evt_id']."</td>";
        echo "<td>".$row['evt_start']."</td>";
        echo "<td>".$row['evt_end']."</td>";
        echo "<td>".$row['evt_text']."</td>";
        echo "<td>".$row['urgency']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "<td>".$diff->format("%R%a days")."</td>";
        echo "</tr>";
    }
    echo "</table>";
    $userid=$_SESSION['id'];
    $important = 'important';
    $query = $conn->prepare("SELECT * FROM `events` WHERE userid = :userid AND urgency = :urgency AND status = :status");
    $params = array(":userid"=>$userid, ":urgency"=>$important, ":status"=>00);
    $query->execute($params);
    $result = $query->fetchAll();
    $query->closeCursor();
    $start = date_create("Y.m.d h:i:sa");
    $end = date_create('evt_start');
    echo "<table>";
    foreach($result as $row){
        date_default_timezone_set('America/Los_Angeles');
        $start = new DateTime('now');
        $end = date_create($row['evt_start']);
        $diff = date_diff($start, $end);       
        echo "<tr>";
        echo "<td>".$row['evt_id']."</td>";
        echo "<td>".$row['evt_start']."</td>";
        echo "<td>".$row['evt_end']."</td>";
        echo "<td>".$row['evt_text']."</td>";
        echo "<td>".$row['urgency']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "<td>".$diff->format("%R%a days")."</td>";
        echo "</tr>";
    }
    echo "</table>";
    $userid=$_SESSION['id'];
    $normal = 'normal';
    $query = $conn->prepare("SELECT * FROM `events` WHERE userid = :userid AND urgency = :urgency AND status = :status");
    $params = array(":userid"=>$userid, ":urgency"=>$normal, ":status"=>00);
    $query->execute($params);
    $result = $query->fetchAll();
    $query->closeCursor();

    $start = date_create("Y.m.d h:i:sa");
    $end = date_create('evt_start');
    echo "<table>";
    foreach($result as $row){
        date_default_timezone_set('America/Los_Angeles');
        $start = new DateTime('now');
        $end = date_create($row['evt_start']);
        $diff = date_diff($start, $end);       
        echo "<tr>";
        echo "<td>".$row['evt_id']."</td>";
        echo "<td>".$row['evt_start']."</td>";
        echo "<td>".$row['evt_end']."</td>";
        echo "<td>".$row['evt_text']."</td>";
        echo "<td>".$row['urgency']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "<td>".$diff->format("%R%a days")."</td>";
        echo "</tr>";
    }
    echo "</table>";
    //Checked tasks
    echo "completed tasks:";
    $urgency= 'veryimportant';
    $query = $conn->prepare("SELECT * FROM `events` WHERE userid = :userid AND urgency = :urgency AND status = :status");
    $params = array(":userid"=>$userid, ":urgency"=>$urgency, ":status"=>1);
    $query->execute($params);
    $result = $query->fetchAll();
    $query->closeCursor();
    $start = date_create("Y.m.d h:i:sa");
    echo "<table>";
    foreach($result as $row){
        date_default_timezone_set('America/Los_Angeles');
        $start = new DateTime('now');
        $end = date_create($row['evt_start']);
        $diff = date_diff($start, $end);       
        echo "<tr>";
        echo "<td>".$row['evt_id']."</td>";
        echo "<td>".$row['evt_start']."</td>";
        echo "<td>".$row['evt_end']."</td>";
        echo "<td>".$row['evt_text']."</td>";
        echo "<td>".$row['urgency']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "<td>".$diff->format("%R%a days")."</td>";
        echo "</tr>";
    }
    echo "</table>";
    $userid=$_SESSION['id'];
    $important = 'important';
    $query = $conn->prepare("SELECT * FROM `events` WHERE userid = :userid AND urgency = :urgency AND status = :status");
    $params = array(":userid"=>$userid, ":urgency"=>$important, ":status"=>1);
    $query->execute($params);
    $result = $query->fetchAll();
    $query->closeCursor();
    $start = date_create("Y.m.d h:i:sa");
    $end = date_create('evt_start');
    echo "<table>";
    foreach($result as $row){
        date_default_timezone_set('America/Los_Angeles');
        $start = new DateTime('now');
        $end = date_create($row['evt_start']);
        $diff = date_diff($start, $end);       
        echo "<tr>";
        echo "<td>".$row['evt_id']."</td>";
        echo "<td>".$row['evt_start']."</td>";
        echo "<td>".$row['evt_end']."</td>";
        echo "<td>".$row['evt_text']."</td>";
        echo "<td>".$row['urgency']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "<td>".$diff->format("%R%a days")."</td>";
        echo "</tr>";
    }
    echo "</table>";
    $userid=$_SESSION['id'];
    $normal = 'normal';
    $query = $conn->prepare("SELECT * FROM `events` WHERE userid = :userid AND urgency = :urgency AND status = :status");
    $params = array(":userid"=>$userid, ":urgency"=>$normal, ":status"=>1);
    $query->execute($params);
    $result = $query->fetchAll();
    $query->closeCursor();

    $start = date_create("Y.m.d h:i:sa");
    $end = date_create('evt_start');
    echo "<table>";
    foreach($result as $row){
        date_default_timezone_set('America/Los_Angeles');
        $start = new DateTime('now');
        $end = date_create($row['evt_start']);
        $diff = date_diff($start, $end);       
        echo "<tr>";
        echo "<td>".$row['evt_id']."</td>";
        echo "<td>".$row['evt_start']."</td>";
        echo "<td>".$row['evt_end']."</td>";
        echo "<td>".$row['evt_text']."</td>";
        echo "<td>".$row['urgency']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "<td>".$diff->format("%R%a days")."</td>";
        echo "</tr>";
    }
    echo "</table>";
}
function DisplayStates(){
    require("config.php");
    $userid = $_SESSION['id'];
    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    try {
        $conn = new PDO($connection_string, $dbuser, $dbpass);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    $query = $conn->prepare("SELECT * FROM `events` WHERE userid= :userid");
    $params = array("userid"=>$userid);
    $query->execute($params);
    $res = $query->fetchAll();
    $complete = 0;
    $not = 0;
    foreach($res as $row){
      if($row['status']==00){
        $complete +=1;
      }
      else{
        $not +=1;
      }
    }
    echo "Completed Tasks: ".$complete."<br>";
    echo "Uncompleted Tasks: ".$not."<br>";

}
function CreateTask(){
    try{
        //echo "step1";
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        if(isset($_POST['eventdate']) && isset($_POST['eventname']) && isset($_POST['desc']) && isset($_POST['urgency'])){
            $eventdate = $_POST['eventdate'];
            $eventname = $_POST['eventname'];
            $desc = $_POST['desc'];
            $urgency = $_POST['urgency'];
            $userid = $_SESSION['id'];
        }
        else{
            echo"something not set";
            exit();
        }
    }
    catch(Exception $e){
        echo "idk: " . $e->getMessage();
    }
    //echo " step2";
    try {
        $conn = new PDO($connection_string, $dbuser, $dbpass);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    //echo " step3";
    try{
        $query = $conn->prepare("INSERT INTO `events` (evt_start, evt_text, urgency, description, userid) VALUES (:eventdate, :eventname, :urgency,:desc, :userid)");
        $params = array(":eventdate"=> $eventdate,":eventname"=> $eventname, ":desc"=> $desc, ":urgency"=> $urgency, ":userid"=> $userid);
        $query->execute($params);
    }
    catch(PDOException $e)
    {
        echo "SQL failed: " . $e->getMessage();
    }
}
function DeleteTask(){
    echo("step1");
    require("config.php");
    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    if(isset($_POST['eventID'])){
        $evt_id = $_POST['eventID'];
    }
    else{
        exit();
    }
    try {
        $conn = new PDO($connection_string, $dbuser, $dbpass);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    echo("step2");
    try{
        $query = $conn->prepare("DELETE FROM `events` WHERE evt_id = :evt_id");
        $params = array(":evt_id"=>$evt_id);
        $query->execute($params);
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
}
function ModifyTask(){
    //echo "step1";
    require("config.php");
    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    echo"step1.1";
    if(isset($_POST['eventID']) && isset($_POST['eventdate']) && isset($_POST['eventname']) && isset($_POST['desc']) && isset($_POST['urgency'])){
        $evt_id = $_POST['eventID'];
        $eventdate = $_POST['eventdate'];
        $eventname = $_POST['eventname'];
        $desc = $_POST['desc'];
        $urgency = $_POST['urgency'];
    }
    else{
        echo"wrong";
        exit();
    }
    //echo "step2";
    try {
        $conn = new PDO($connection_string, $dbuser, $dbpass);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    //echo"step3";
    try{
        $query = $conn->prepare("UPDATE `events` SET evt_start = :eventdate, evt_text = :eventname, urgency = :urgency, description = :desc WHERE evt_id= :evt_id");
        $params = array(":eventdate"=> $eventdate,":eventname"=> $eventname, ":desc"=> $desc, ":urgency"=> $urgency, ":evt_id"=> $evt_id);
        $query->execute($params);
    }
    catch(PDOException $e){
        echo "SQL failed: " . $e->getMessage();
    }
}
function TaskStatus(){
    require("config.php");
    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    if(isset($_POST['eventID'])){
        $evt_id = $_POST['eventID'];
    }
    else{
        echo "wrong";
        exit();
    }
    try {
        $conn = new PDO($connection_string, $dbuser, $dbpass);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    //echo"step1";
    $query = $conn->prepare("SELECT * FROM `events` WHERE evt_id= :evt_id");
    $params = array(":evt_id"=>$evt_id);
    $query->execute($params);
    $res = $query->fetch();
    if($res['status']==00){
        $query = $conn->prepare("UPDATE `events` SET status = :state WHERE evt_id= :evt_id");
        $params = array(":state"=>01, ":evt_id"=>$evt_id);
        $query->execute($params);
    }
    else{
        $query = $conn->prepare("UPDATE `events` SET status = :state WHERE evt_id= :evt_id");
        $params = array(":state"=>00, ":evt_id"=>$evt_id);
        $query->execute($params);
    }


}
DisplayTasks();
if(isset($_POST['display'])){
    DisplayTasks();
}
if(isset($_POST['createButton'])){
    echo "create";
    CreateTask();
}

if(isset($_POST['modifyButton'])){
    ModifyTask();
}

if(isset($_POST['deleteButton'])){
    DeleteTask();
}

if(isset($_POST['stateButton'])){
    TaskStatus();
}
?>