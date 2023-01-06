<?php
session_start();

if(!isset($_SESSION['username'])){
  ?>

 <script>
   alert("Do log in first");
    location.replace("index.html");
  </script>

<?php
  exit();
}

$showAlert = false;
$showAlert1 = false;
include 'databaseConnect.php';
if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_FILES['profilepic'])){

  $roll = $_POST['rollNo'];
  $firstName = $_POST['first'];
  $lastName = $_POST['last'];
  $branch = $_POST['branch'];
  $year = $_POST['year'];
  $from = $_POST['start'];
  $to = $_POST['end'];
  $username = $_POST['usernameStd'];
  $pass = $_POST['passwordStd'];

  $password = password_hash($pass,PASSWORD_DEFAULT);
  $sql = "INSERT INTO `addstudent` (`rollNumber`, `firstName`, `lastName`, `Branch`, `year`, `sessionFrom`, `sessionTo`, `usernameStd`, `passwordStd`)
   VALUES ('$roll', '$firstName', '$lastName', '$branch', '$year', '$from', '$to', '$username', '$password')";
  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "Error! The Student cannot be added to the library list due to -->" .mysqli_error($conn);
  } else{
    $showAlert = true;
  }
}
if($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_POST['usernameStd'])){
  // print_r ($_FILES['profilepic']);
  $filename = $_FILES['profilepic']['name'];
  $filetemp = $_FILES['profilepic']['tmp_name'];
  $folder = "profile/".$filename;
  $move = move_uploaded_file($filetemp, $folder);
  $username = $_POST['confirmation'];
  // echo $username;
  $sql = "UPDATE `addstudent` SET `imgname` = '$filename' WHERE usernameStd = '$username';";
  mysqli_query($conn, $sql);
  $showAlert1 = true;
}

// echo $_FILES['profilepic'];

  // $filename = $_FILES['profilepic']['name'];
  // $filetemp = $_FILES['profilepic']['temp_name'];
  // $folder = "profile/".$filename;
  // move_uploaded_file($filetemp, $folder);



?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Library</title>
  <link rel="stylesheet" href="style.css" style="float: right;">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
<?php
if($showAlert){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> The Student has been added to the library list.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
if($showAlert1){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> The Profile has been updated.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
?>
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
      <nav class="nav flex-column px-1">
        <a class="nav-link form-control input-group-text my-2" href="About.php">About</a>
        <a class="nav-link form-control input-group-text my-2" href="AddBook.php">Add Book</a>
        <a class="nav-link form-control input-group-text my-2" href="#" style="background-color: whitesmoke;">Add
          Student</a>
        <a class="nav-link form-control input-group-text my-2" href="IssueBook.php">Issue Book</a>
        <a class="nav-link form-control input-group-text my-2" href="ReturnBook.php">Return Book</a>
        <a class="nav-link form-control input-group-text my-2" href="SearchBook.php">Search Book</a>
        <a class="nav-link form-control input-group-text my-2" href="Report.php">Issue/Return Book Report</a>
        <a class="nav-link form-control input-group-text my-2" href="LogOut.php">Log Out</a>
      </nav>
    </div>
    <div style="width: 80%; float: right;" class="form-control">
      <form action="" method="post">
        <div class="input-group">
          <span class="input-group-text">Enter The Roll Number</span>
          <input type="text" class="form-control" placeholder="Complete Roll No." name="rollNo" required>
        </div>
        <br>
        <div class="input-group">
          <span class="input-group-text">Student Name</span>
          <input type="text" class="form-control" placeholder="First" name="first" required>
          <input type="text" class="form-control" placeholder="Last" name="last" required>
        </div>
        <br>
        <select class="form-select" aria-label="Default select example" name="branch" required>
          <option selected>Select the Branch of the Student</option>
          <option value="Computer Science Engineering">Computer Science Engineering</option>
          <option value="Electrical Engineering">Electrical Engineering</option>
          <option value="Mechanical Engineering">Mechanical Engineering</option>
          <option value="Civil Engineering">Civil Engineering</option>
          <option value="Electonics and Communication Engineering">Electonics and Communication Engineering</option>
          <option value="Computer Science AI">Computer Science AI</option>
        </select>
        <br>
        <select class="form-select" aria-label="Default select example" name="year" required>
          <option selected>The year of studying</option>
          <option value="I">I</option>
          <option value="II">II</option>
          <option value="III">III</option>
          <option value="IV">IV</option>
        </select>
        <br>
        <div class="input-group">
          <span class="input-group-text">Session</span>
          <input type="text" class="form-control" placeholder="From" name="start" required>
          <input type="text" class="form-control" placeholder="To" name="end" required>
        </div>
        <br>
        <div class="input-group">
          <span class="input-group-text">Enter Library Card Number</span>
          <input type="text" class="form-control" placeholder="The System automatcially assigns it" disabled name="cardNo">
        </div>
        <br>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">@</span>
          <input type="text" maxlength ="50" class="form-control" placeholder="Username" name="usernameStd" required>
          <span class="input-group-text" id="basic-addon1">*</span>
          <input type="password" maxlength ="50" class="form-control" placeholder="Password" name="passwordStd" required>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto" style="display : inline-block;">
          <input class="btn btn-primary btn-sm" type="submit"></input>
          <input class="btn btn-secondary btn-sm" type="Reset"></input>
        </div>
      </form>
      <br>
      <form method="post" enctype = "multipart/form-data">
      <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">@</span>
          <input type="text" maxlength ="50" class="form-control" placeholder="Enter your Username here" name="confirmation" required>
        </div>
      <div class="input-group">
          <span class="input-group-text">Upload your profile pic</span>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="file" accept=".jpg,.jpeg,.png" class="form-control" name="profilepic" required>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input class="btn btn-secondary btn-sm" type="submit" value = "Upload" style="width : 30%"></input>
        </div>
      </form>
    </div>
    <footer class="form-control input-group-text mt-5">
      &copy; Priyanshu Shukla
    </footer>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
    crossorigin="anonymous"></script>
</body>

</html>