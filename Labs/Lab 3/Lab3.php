<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

  </body>
</html>
<?php
//Question 1
echo 'Tomorrow I \'ll learn PHP with forms.';
echo "<br>";
echo 'This is a bad command : delee c:\\*.*';
echo "<br>";

//Question 2
$str = 'debugging|is+hard';
$find = "|";
$replace = ", ";
$str = str_replace($find, $replace, $str);
$find = "+";
$str = str_replace($find, $replace, $str);
echo $str;
echo "<br>";
$strArr = explode(", ", $str);
\array_splice($strArr, 2, 2);
array_push($strArr, "easy");
print_r($strArr, false);
echo "<br>";

//Question 3
$prices = array(120, 119, 10.95, 411);
$sum = 0;
foreach ($prices as $price){
  $sum = $sum + $price;
}
echo $sum;
echo "<br>";

//Question 4
//average temp
$temps = array(68, 70, 72, 58, 60, 79, 82, 73, 75, 77, 73, 58, 63, 79, 78, 68, 72, 73, 80, 79, 68, 72, 75, 77, 73, 78, 82, 85, 89, 83);
$days = sizeof($temps);
$average = 0;
foreach($temps as $temp){
  $average = $average + $temp;
}
$average = $average/$days;
echo $average;
echo "<br>";
//first 10 $days
$tempArr = array_slice($temps,0,10,false);
$average10 = array_sum($tempArr)/10;
echo $average10;
echo "<br>";
//hot days
rsort($temps, SORT_NUMERIC);
$hot = array_slice($temps,0,5,true);
print_r($hot, false);
echo "<br>";
//cold days
$cold = array_slice($temps,-5,5,false);
print_r($cold, false);
echo "<br>";
?>
