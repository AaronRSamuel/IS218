<?php
$date =  date('Y-m-d', time());
echo "The value of \$date: ".$date."<br>";
$tar = "2017/05/24";
echo "The value of \$tar: ".$tar."<br>";
$year = array("2012", "396", "300","2000", "1100", "1089");
echo "The value of \$year: ";
print_r($year);

//Q1
echo "QUESTION 1: ";
$date = str_replace('-', '/', $date);
echo $date."<br>";

//Q2
echo "QUESTION: 2: ";
if(strcmp($date, $tar)>0){
  echo"the past<br>";
}
elseif (strcmp($date, $tar)<0) {
  echo"the future<br>";
}
else{
  echo"oops<br>";
}
//Q3
echo "QUESTION: 3: ";
$splitdate = str_split($date);
$count = count($splitdate);
for($i=0;$i<$count;$i++){
  if($splitdate[$i]=='/'){
    echo $i." ";
  }
}
//Q4
echo "<br>QUESTION: 4: ";
echo str_word_count($date)."<br>";

//Q5
echo "QUESTION: 5: ";
$valueOfFirst = ord("hello IS218");
echo $valueOfFirst."<br>";

//Q6
echo "QUESTION: 6: ";
$stringEx = 'this is homework for php basics';
echo strlen($stringEx)."<br>";

//Q7
echo "QUESTION: 7: ";
$sub7 = substr($date,-2);
echo $sub7."<br>";

//Q8
echo "QUESTION: 8: ";
$splitdate = str_split($date);
$count = count($splitdate);
$content = array();
$count2 = 0;
for($i=0;$i<$count;$i++){
  if($splitdate[$i]!='/'){
    $content[$count2] = $splitdate[$i];
    $count2++;
  }
}
print_r($content);
//Q9
echo "<br>QUESTION: 9:<br> ";
$namesAndStuff = array(
    ["name"=>"John Doe", "phone"=>"123-345-6789", "email"=>"jd@gmail.com", "address"=>"11 Rock Ave, Newark, NJ", "salary"=>100],
    ["name"=>"Collin L", "phone"=>"245-333-4456", "email"=>"cl@njit.edu", "address"=>"23 Rock Ave, Newark, DE", "salary"=>112],
    ["name"=>"John L", "phone"=>"222-000-1111", "email"=>"jl@njit.edu", "address"=>"234 lookGood Ave, CA", "salary"=>200],
    ["name"=>"IS C218", "phone"=>"112-123-2345", "email"=>"ic@hotmail.com", "address"=>"25 link RD, LA, CA", "salary"=>234]
  );

  // print employee records
  print_r("All Records:<br>");
  foreach($namesAndStuff as $employeeDet){
    printf("name: %s<br>",$employeeDet['name']);
    printf("phone: %s<br>",$employeeDet['phone']);
    printf("email: %s<br>",$employeeDet['email']);
    printf("address: %s<br>",$employeeDet['address']);
    printf("salary: %.2fK<br>",$employeeDet['salary']);
    printf("=============================<br>");
    echo "<br>";
  }

  //Part a
  $TFN = "John";
  $Total_salary = array();
  foreach($namesAndStuff as $employeeDet) {
      $Fname = explode(" ", $employeeDet['name'])[0];
      if($Fname == $TFN) {
          array_push($Total_salary, $employeeDet['salary']);
      }
  }
  $average = array_sum($Total_salary)/count($Total_salary);
  printf("Average Salary of employees with first name '%s' is %.2fK", $TFN, $average);
  echo "<br>";

  // Part b
  $TLN = "L";
  $phones = array();
  foreach($namesAndStuff as $employeeDet) {
      $LN = explode(" ", $employeeDet['name'])[1];
      if($LN == $TLN) {
          array_push($phones, $employeeDet['phone']);
      }
  }
  print_r("Phones of employees with last name as '".$TLN."':");
  echo "<br>";
  foreach($phones as $number){
    printf($number);
    echo "<br>";
  }

  // part c
  $Total_salary = array();
  foreach($namesAndStuff as $employeeDet) {
      $address = explode(", ", $employeeDet['address']);
      $country = end($address);
      if($country == "CA") {
          array_push($Total_salary, $employeeDet['salary']);
      }
  }
  printf("Average Salary of employees who reside in 'CA':<br> %.2fK", array_sum($Total_salary)/count($Total_salary));
  echo "<br>";

  // part d
  print_r("Employees' full names who have a salary > 200k:<br>");
  $names = array();
  foreach($namesAndStuff as $employeeDet) {
      if($employeeDet['salary'] > 200) {
          array_push($names, $employeeDet['name']);
      }
  }
  foreach($names as $name){
    printf($name);
    echo "<br>";
  }
?>
