<?php
include 'databaseConnect.php';
$conn = mysqli_connect($host, $username, $password, $db);
mysqli_select_db($conn, $db);

session_start();
if(isset($_SESSION['username']) && $_SESSION['username']=="prianshukla"){
  echo '<script> location.replace("About.php")</script>';
}

if(isset($_POST['username'])){
   $uname = $_POST['username'];
   $pass = $_POST['password'];

   $sql = "select * from liblogin where Username='".$uname."'AND Password='".$pass."'
   limit 1";

   $result = mysqli_query($conn, $sql);

   if(mysqli_num_rows($result)==1){
     $_SESSION['username'] = $uname;

    //  echo "You have successfully logged in";
    header("Location: About.php"); 
    // echo "<script> location.href='About.php'";
    //  exit();
   }else{
     echo "The entries are incorrect"; 
    //  header("Location: login.php");
    //  echo "<script> location.href='login.php'"; 
   }
}

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  </head>
  <body>
    <div class="shadow p-3 mb-5 bg-body rounded container">
      <header>
        <div class="input-group-text">
            <h1 style="font-size: 2vw;">Library Management System</h1>
            <img src="images/logo.png" style="margin-left: 45%; max-width: 20vw;" >
        </div>
      </header>
        <div class="form mt-5">
          <div class="input-group input-group-lg my-3">
            <h2 class="input-group -text d-inline">Log In(Admin)</h2>
          </div>
            <form method="post" class="logIn">
                  <div class="input-group input-group-lg m-3">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                  </div>
                  <div class="input-group input-group-lg m-3">
                    <span class="input-group-text" id="basic-addon1">* &nbsp;</span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                  </div>
                  <!-- <div class="input-group mx-3">
                      <a href="#">Forgot Password</a>
                  </div> -->
                  <div class="input-group input-group-lg mx-3">
                    <button class="btn btn-outline-secondary my-3 text-white bg-primary" type="submit" id="submit">Submit</button>
                  </div> 
            </form>
            </form>
        </div>
        <footer class="form-control input-group-text mt-5">
          &copy; Priyanshu Shukla
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>