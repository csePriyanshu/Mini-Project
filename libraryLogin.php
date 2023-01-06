<?php
session_start();
include 'databaseConnect.php';
mysqli_select_db($conn, $db);

if(isset($_POST['username'])){
   $uname = $_POST['username'];
   $pass = $_POST['password'];

   $sql = "select * from liblogin where Username='".$uname."'AND Password='".$pass."'
   limit 1";
   $result = mysqli_query($conn, $sql);
   $num = mysqli_num_rows($result);
   if($num==1){
     while($row = mysqli_fetch_assoc($result)){
       if(password_verify($pass, $row['passwordStd'])){
         $_SESSION['username'] = $uname;
         $_SESSION['loggedin'] = true;
        header("Location: About.php"); 
        }
      }
    }
   else{
     echo "The entries are incorrect";  
   }
}

?>