<?php
session_start();
$showAlert = false;
if(!isset($_SESSION['username'])){
  ?>

 <script>
   alert("Do log in first");
    location.replace("index.php");
  </script>

<?php
  exit();
}


if($_SERVER["REQUEST_METHOD"] == "POST"){
  include 'databaseConnect.php';
  $id = $_POST['id'];
  $title = $_POST['title'];
  $branch = $_POST['branch'];
  $year = $_POST['year'];
  $boughton = $_POST['bought'];
  $author = $_POST['author'];
  $price = $_POST['price'];
  $qnt = "SELECT `Title` , `QuantityAvailable` FROM `book`";
  $qnty = mysqli_query($conn,$qnt);
  $quantity = $_POST['quantity'];
  while($row = mysqli_fetch_assoc($qnty)){
    $tmp = $row['Title'];
    if($title == $tmp){
      $quantity = $row['QuantityAvailable'];
    }
  }
  $sql = "INSERT INTO `book` (`BookId`, `Title`, `Branch`, `Year`, `BoughtOn`, `Author`, `Price`, `QuantityAvailable`)
   VALUES ('$id', '$title', '$branch', '$year', '$boughton', '$author', '$price', '$quantity')";
  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "Error! The Book cannot be added to the library list due to -->" .mysqli_error($conn);
  } else{
    $showAlert = true;
  }
}

?>





<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library</title>
    <link rel="stylesheet" href="style.css" style="float: right;">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  </head>
  <body>
  <?php
  if($showAlert){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> The Book has been added to the library list.
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
                <img src="images/logo.png" style="margin-left: 45%; max-width: 20vw;" >
            </div>
        </header>
        <br>
        <div class="columnLeft" style="width: 20%; padding: 0px; float: left;">
            <nav class="nav flex-column px-1">
                <a class="nav-link form-control input-group-text my-2" href="About.php">About</a>
                <a class="nav-link form-control input-group-text my-2" href="#" style="background-color: whitesmoke;">Add Book</a>
                <a class="nav-link form-control input-group-text my-2" href="AddStudent.php">Add Student</a>
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
          <span class="input-group-text">Book Id</span>
          <input type="text" class="form-control" placeholder="As given by Lib" name="id" required>
        </div>
        <br>
        <div class="input-group">
          <span class="input-group-text">Book Title</span>
          <input type="text" class="form-control" placeholder="Title of the Book" name="title" required>
        </div>
        <br>
        <select class="form-select" aria-label="Default select example" name="branch">
          <option selected>Select the Branch of the Student</option>
          <option value="Computer Science Engineering">Computer Science Engineering</option>
          <option value="Electrical Engineering">Electrical Engineering</option>
          <option value="Mechanical Engineering">Mechanical Engineering</option>
          <option value="Civil Engineering">Civil Engineering</option>
          <option value="Electonics and Communication Engineering">Electonics and Communication Engineering</option>
          <option value="Computer Science AI">Computer Science AI</option>
        </select>
        <br>
        <select class="form-select" aria-label="Default select example" name="year">
          <option selected>For which year</option>
          <option value="1">I</option>
          <option value="2">II</option>
          <option value="3">III</option>
          <option value="4">IV</option>
        </select>
        <br>
        <div class="input-group">
          <span class="input-group-text">Date Bought</span>
          <input type="date" class="form-control" placeholder="bought on" name="bought" required>
        </div>
        <br>
        <div class="input-group">
          <span class="input-group-text">Author</span>
          <input type="text" class="form-control" placeholder="Publications" name="author">
        </div>
        <br>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Price</span>
          <input type="text" maxlength ="50" class="form-control" placeholder="in rupees" name="price" required>
          <span class="input-group-text" id="basic-addon1">Availability</span>
          <input type="text" maxlength ="50" class="form-control" placeholder="qantity" name="quantity" required>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto" style="display : inline-block;">
          <input class="btn btn-primary btn-sm" type="submit"></input>
          <input class="btn btn-secondary btn-sm" type="Reset"></input>
        </div>
      </form>
        </div>
        <footer class="form-control input-group-text mt-5">
            &copy; Priyanshu Shukla
          </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>