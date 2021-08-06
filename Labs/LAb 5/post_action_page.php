<?php
echo "we are in post_action_page.php<br>";
echo $_POST["firstname"].'<br>';
echo $_POST["lastname"].'<br>';

$first_nameP = filter_input(INPUT_POST, 'firstname');
$last_nameP = filter_input(INPUT_POST, 'lastname');
echo "First name is: $first_nameP<br> Last name is: $last_nameP";
?>
