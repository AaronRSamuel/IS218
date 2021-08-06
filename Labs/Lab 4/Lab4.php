<?php
$cap = [
  "Italy"=>"Rome",
  "Luxembourg"=>"Luxembourg",
  "Belgium"=> "Brussels",
  "Denmark"=>"Copenhagen",
  "Finland"=>"Helsinki",
  "France" => "Paris"
];
arsort($cap);
foreach ($cap as $key => $value) {
  echo "$value, $key \n";
}
$citys = array (
  array("Tokyo", "Japan", "Asia"),
  array("Mexico City", "Mexico", "North America"),
  array("New York", "USA", "North America"),
  array("Mumbai", "India", "Asia"),
  array("Lagos", "Nigeria", "Africa"),
  array("Buenos Aires", "Argentina", "South America"),
  array("Cairo", "India", "Africa"),
  array("London", "UK", "Europe"),
);
echo "<br>Question 2<br>North America:<br>";
for($i = 0; $i < 8; $i++){
    if($citys[$i][2] == "North America"){
      $cont = $citys[$i][2];
      $coun = $citys[$i][1];
      $city = $citys[$i][0];
      echo "$cont, $coun, $city<br>";
    }
}
echo "***<br>Europe:<br>";
for($i = 0; $i < 8; $i++){
    if($citys[$i][2] == "Europe"){
      $cont = $citys[$i][2];
      $coun = $citys[$i][1];
      $city = $citys[$i][0];
      echo "$cont, $coun, $city<br>";
    }
}
echo "***<br>Africa: <br>";
for($i = 0; $i < 8; $i++){
    if($citys[$i][2] == "Africa"){
      $cont = $citys[$i][2];
      $coun = $citys[$i][1];
      $city = $citys[$i][0];
      echo "$cont, $coun, $city<br>";
    }
}
echo "***<br>Asia:<br>";
for($i = 0; $i < 8; $i++){
    if($citys[$i][2] == "Asia"){
      $coun = $citys[$i][1];
      $city = $citys[$i][0];
      echo "$coun, $city<br>";
    }
}
echo "***<br>South America:<br>";
for($i = 0; $i < 8; $i++){
    if($citys[$i][2] == "South America"){
      $cont = $citys[$i][2];
      $coun = $citys[$i][1];
      $city = $citys[$i][0];
      echo "$cont, $coun, $city<br>";
    }
}
 ?>
