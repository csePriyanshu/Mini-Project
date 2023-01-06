<?php
session_start();
include 'databaseConnect.php';
error_reporting(0);

if(!isset($_SESSION['username'])){
  ?>

 <script>
   alert("Do log in first");
    location.replace("index.html");
  </script>

<?php
  exit();
}

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Library</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
  <div class="shadow p-3 mb-5 bg-body rounded container">
    <!-- <header class="p-3 mb-2 input-group-text rounded">
            <img src="images/logo.png">
            <img src="images/logo-2.png">
            <br><h1>Library Management System</h1>
        </header> -->
    <header>
      <div class="input-group-text">
        <h1 style="font-size: 2vw;">Library Management System</h1>
        <img src="images/logo.png" style="margin-left: 45%; max-width: 20vw;">
      </div>
    </header>
    <br>
    <div class="columnLeft" style="width: 20%; padding: 0px; float: left;">
    <?php 
          $username = $_SESSION['username'];
          $query = "SELECT `imgname` FROM `addstudent` WHERE `usernameStd` = '$username'";
          $result = mysqli_query($conn, $query);
          
          while($row = mysqli_fetch_assoc($result)){
            $image = $row['imgname'];
          }
          if($image ==""){
            if($num == 0){
              echo '
              <form method="post" enctype = "multipart/form-data">
                <span class="input-group-text">Update your profile pic</span>
                <br>
                <input type="file" accept=".jpg,.jpeg,.png" class="form-control" name="profilepic" required>
                <br>
                <input class="btn btn-secondary btn-sm" type="submit" value = "Upload" style="width : 30%"></input>
              </form>
              ';
            if($_SERVER['REQUEST_METHOD'] == "POST"){
              // print_r ($_FILES['profilepic']);
              $filename = $_FILES['profilepic']['name'];
              $filetemp = $_FILES['profilepic']['tmp_name'];
              $folder = "profile/".$filename;
              $move = move_uploaded_file($filetemp, $folder);
              // echo $username;
              $sql = "UPDATE `addstudent` SET `imgname` = '$filename' WHERE usernameStd = '$username';";
              mysqli_query($conn, $sql);
              $showAlert1 = true;
            }
            }
          }else{
            echo '<img class="nav-link input-group-text mx-auto my-2" style="background-color: whitesmoke;
             max-width : 100vw; height : 189px"
            src="./profile/'.$image.'">';
          }
          // echo $image;
          // echo $username;
          // echo '<br> jpg.jpg';
          // $folder = "./profile/".$image;
          // echo $folder = "./profile/".$image;
          
        ?>
      <nav class="nav px-1 navBar">
        <a class="nav-link form-control input-group-text my-2" href="#" style="background-color: whitesmoke;">About</a>
        <!-- <a class="nav-link form-control input-group-text my-2" href="AddBook.php">Add Book</a> -->
        <!-- <a class="nav-link form-control input-group-text my-2" href="AddStudent.php">Add Student</a> -->
        <!-- <a class="nav-link form-control input-group-text my-2" href="IssueBook.php">Issue Book</a> -->
        <!-- <a class="nav-link form-control input-group-text my-2" href="ReturnBook.php">Return Book</a> -->
        <a class="nav-link form-control input-group-text my-2" href="SearchBookStd.php">Search Book</a>
        <a class="nav-link form-control input-group-text my-2" href="ReportStd.php">Issue/Return Book Report</a>
        <a class="nav-link form-control input-group-text my-2" href="LogOut.php">Log Out</a>
      </nav>
    </div>
    <div style="width: 80%; text-align :center; float :right;" class="form-control mt-2">
      <b> 
      <?php 
        $uname = $_SESSION['username'];
        $sql = "select * from addstudent where usernameStd='$uname'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)){
          $_SESSION['fname'] = $row['firstName'];
          $_SESSION['lastname'] = $row['lastName'];
          $_SESSION['cardnumber'] = $row['cardNumber'];
          $_SESSION['branch'] = $row['Branch'];
          $_SESSION['year'] = $row['year'];
          $_SESSION['rollnumber'] = $row['rollNumber'];
        }
        $fname = $_SESSION['fname'];
        $lname = $_SESSION['lastname'];
        $cardno = $_SESSION['cardnumber'];
        $branch = $_SESSION['branch'];
        $year = $_SESSION['year'];
        $roll = $_SESSION['rollnumber'];
        ?>
        <span class="input-group-text" id="basic-addon1">
          <span style ="width :40%; background-color: white; border-radius : 5px; float:left;">
            <br>Name<hr><br>Library Card Number<hr><br>Roll Number<hr><br>Branch<hr><br>Year<hr>
          </span>
          <span class="ms-1" style ="width :60%; background-color: white; border-radius : 5px; float:left;">
            <br><?php echo $fname.' ' .$lname ?><hr><br><?php echo $cardno ?><hr><br><?php echo $roll ?><hr><br>
            <?php echo $branch ?><hr><br><?php echo $year ?><hr>
          </span>
        </span>
        <br>
        <?php
        $sql = "SELECT Fine FROM addstudent where rollNumber = '$roll'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
          $fine = $row['Fine'];
        }
        ?>
        <div class="d-inline p-2 bg-secondary border border-danger rounded text-white" style = "float:left;">Fine you need to pay : <?php echo $fine ?> rupees</div>
        <?php
        // echo
        // '<span class="input-group-text" id="basic-addon1">Name : &nbsp;</span>'.$fname.' ' .$lname .
        // '<br><br>Library Card No. : &nbsp;'. $cardno .
        // '<br><br>Roll Number : &nbsp;'.$roll .
        // '<br><br>Branch : &nbsp;'. $branch .
        // '<br><br>Year : &nbsp;'. $year .  
        // "<br>";
        // echo "<br>";
        // echo "Branch : "; echo $_SESSION['userinfo']['lastname'];
      ?></b>
    </div>
    <br>
    <footer class="form-control input-group-text mt-5">
      &copy; Priyanshu Shukla
    </footer>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
    crossorigin="anonymous"></script>
</body>

</html>