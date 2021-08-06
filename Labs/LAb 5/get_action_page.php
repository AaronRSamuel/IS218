<?php
echo "we are in get_action_page.php<br>";

if(isset($_GET["firstname"])){
	echo $_GET["firstname"].'<br>';
}

if(isset($_GET["lastname"])) {
	echo "hello";
	echo $_GET["lastname"].'<br>';
}

if (isset($_GET["password"])){
    echo $_GET["password"].'<br>';
}

//write the filter_input version for the text input.
  $first_nameG = filter_input(INPUT_GET, 'firstname');
  $last_nameG = filter_input(INPUT_GET, 'lastname');
  $password = filter_input(INPUT_GET, 'password');
	if(filter_input(INPUT_GET, 'lastname')){
		echo "First name is: $first_nameG<br> Last name is: $last_nameG <br> Password is: $password <br>";
	}
//get values from radio
if (isset($_GET["gender"])){// determine if the value $_GET["gender"] is defined or not.

echo "The Gender is ".$_GET['gender'].'<br>';
$gender = $_GET['gender'];
echo "The gender is $gender<br>";}

//write filter_input version for the radio.
if(filter_input(INPUT_GET, 'gender')){
	$gender = filter_input(INPUT_GET,'gender');
	echo "The gender is $gender<br>";
}
//write filter_input version for the drop-down list.
if(filter_input(INPUT_GET,'card_type')){
	$card_type = filter_input(INPUT_GET,'card_type');
	echo "The card type is $card_type<br>";
}
?>
