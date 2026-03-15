<?php


$first_name = "Alexis";
$last_name = "Dumale";


function fullName($first, $last){
    return $first . " " . $last;
}

function greetUser(){
    global $first_name, $last_name;
    echo "Hello, " . $first_name . " " . $last_name . "!<br>";
}

function welcomeMessage(){
    global $first_name, $last_name;
    
    $name = fullName($first_name, $last_name);
    
    echo "Welcome, " . $name . "! We are happy to have you!";
}


greetUser();
echo "</br>";
welcomeMessage();

?>