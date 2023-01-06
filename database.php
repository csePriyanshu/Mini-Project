<?php
//connecting to a MYSQL database

// using MYSQLi extension

include 'databaseConnect.php';


//create a connection object

$conn = mysqli_connect($servername, $username, $password, $database);


if(!$conn){
    die("We failed to connect!");
} else{
    echo "Connection was successful"; 
    echo "<br>";
}

// create a db 
// $sql = "CREATE DATABASE priyanshu";
// mysqli_query($conn, $sql);


//sql querry to be executed
$sql = "INSERT INTO `book` (`BookId`, `Author`, `Title`, `Price`, `Available`) VALUES ('549585', 'Harsh Bhasin', 'Algorithms Design and Analysis', '545', '1')";
$result = mysqli_query($conn, $sql);
if($result){
    echo "Record has been inserted successfully";
}
else{
    echo "Record was not inserted successfully due to this error --->"
    .mysqli_error($conn);
}
 

?>