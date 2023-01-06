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
  
  // $a = 5;
  // echo $a-1;
  
  
  include 'databaseConnect.php';
          $availability = null ;
          $title ="";
          $author = "";
          $id="";
          if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])){
            $id = $_POST['search'];
            $available = "SELECT `QuantityAvailable` FROM `book` WHERE BookId = '$id'";
            $current = mysqli_query($conn, $available);
            while($row = mysqli_fetch_assoc($current)){
            $availability = $row['QuantityAvailable'];
            }
            $tit = "SELECT `Title` FROM `book` WHERE BookId = '$id'";
            $currenttit = mysqli_query($conn, $tit);
            while($row = mysqli_fetch_assoc($currenttit)){
            $title = $row['Title'];
            // echo $title;
            }
            $auth = "SELECT `Author` FROM `book` WHERE BookId = '$id'";
            $currentauth = mysqli_query($conn, $auth);
            while($row = mysqli_fetch_assoc($currentauth)){
            $author = $row['Author'];
            }
          }
          
  
  $showAlert = false;
  $mydate=getdate(date("U"));
    $getdate = "$mydate[month] $mydate[mday], $mydate[year]";
    $date=date_create($getdate);
    // echo $date;
    // date_add($date,date_interval_create_from_date_string("1 days"));
    $issuedate = date_format($date,"d-m-Y");
    date_add($date,date_interval_create_from_date_string("14 days"));
    $expected = date_format($date,"d-m-Y");
    // echo $issuedate;
    // echo $expected;
  if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['roll'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $branch = $_POST['branch'];
    $roll = $_POST['roll'];
  //   $returndate = $_POST['return'];
    
    // echo $issuedate;
    // $author = $_POST['author'];
    $availability = $_POST['available'];
    $checkId = "SELECT `BookId` FROM `book` WHERE BookId = '$id'";
    $resultid = mysqli_query($conn, $checkId);
    $countid = mysqli_num_rows($resultid);
    $checkRoll = "SELECT `rollNumber` FROM `addstudent` WHERE rollNumber = '$roll'";
    $resultRoll = mysqli_query($conn, $checkRoll);
    $countroll = mysqli_num_rows($resultRoll);
    // echo $countroll.'<br>';
    // echo $countid;
    // echo $id;
   
    // echo $author;
    // $sql = "SELECT `IssueDate` FROM `issuebook` WHERE `BookId` = '$id'";
    // $checkissue = mysqli_query($conn, $sql);
    // $sql = "SELECT `ReturnDate` FROM `issuebook` WHERE `BookId` = '$id'";
    // $checkreturn = mysqli_query($conn, $sql);
    if($countroll>0 && $countid>0){
      // echo $issuedate;
      $issuedate = $_POST['issue'];
      $author = $_POST['author'];
      $sql = "INSERT INTO `issuebook`(`BookId`, `Title`, `Branch`, `RollNo`, `IssueDate`, `ReturnDate`, `Author`)
      VALUES ('$id', '$title', '$branch', '$roll', '$issuedate','','$author')";
      $result = mysqli_query($conn, $sql);
      if(!$result){
        echo "Error! The Book cannot be added to the library list due to -->" .mysqli_error($conn);
      } else{
        $showAlert = true;
        $current = $availability-1;
        $update = "UPDATE `book` SET `QuantityAvailable` = '$current' WHERE `Title` = '$title' ";
        mysqli_query($conn, $update);
      }
    }else if($countid==0 && $countroll==0){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Enter a valid Roll Number and Book Id , please try again.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    } else if($countid==0){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Enter a valid Book Id , please try again.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    } else if($countroll==0){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Enter a valid Roll Number , please try again.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
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
    <div class="shadow p-3 mb-5 bg-body rounded container">
      <?php 

  if($showAlert){
    // echo $current;
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> The Book has been issued to'.$roll.'. Return it on '.$expected.'<br>
          Number of Books Available is '.$current.'
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
?>
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
                <a class="nav-link form-control input-group-text my-2" href="AddBook.php">Add Book</a>
                <a class="nav-link form-control input-group-text my-2" href="AddStudent.php">Add Student</a>
                <a class="nav-link form-control input-group-text my-2" href="#" style="background-color: whitesmoke;">Issue Book</a>
                <a class="nav-link form-control input-group-text my-2" href="ReturnBook.php">Return Book</a>
                <a class="nav-link form-control input-group-text my-2" href="SearchBook.php">Search Book</a>
                <a class="nav-link form-control input-group-text my-2" href="Report.php">Issue/Return Book Report</a>
                <a class="nav-link form-control input-group-text my-2" href="LogOut.php">Log Out</a>
            </nav>
        </div>
        <div style="width: 80%; float: right;" class="form-control">
        <form action="" method="post">
        <div class="input-group" style="width : 15vw; float:right;">
          <input type="text" class="form-control" placeholder="Enter the book id" name="search" style="border-radius :10px 0px 0px 10px;">
          <button class="btn btn-primary btn-sm" type="submit" value ="search" style="border-radius :0px 10px 10px 0px;"><img class="btn btn-primary btn-sm" src="./images/search.png" style="border-radius :0px 10px 10px 0px; max-width:44px;"></button>
        </div>
        <br>
        </form>
        
        <br>
        <form action="" method="post">
        <div class="input-group">
          <span class="input-group-text">Roll Number</span>
          <input type="text" class="form-control" placeholder="Complete Roll Number" name="roll" required>
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
        <div class="input-group">
          <span class="input-group-text">Book Id</span>
          <input type="text" class="form-control" placeholder="Enter Book Id" name="id" id="Bookid" value="" required>
          <script>
            document.getElementById("Bookid").value = "<?php echo $id ?>";
          </script>
        </div>
        <br>
        <div class="input-group">
          <span class="input-group-text">Book Title</span>
          <input type="text" class="form-control" placeholder="Enter Title of the book" name="title" id="title" value="" required>
          <script>
            document.getElementById("title").value = "<?php echo $title ?>";
          </script>
        </div>
        <br>
        <div class="input-group">
          <span class="input-group-text">Date of Issue</span>
          <input type="text" class="form-control" placeholder="Date of issue" name="issue" id="issue" value="" required>
          <script>
            document.getElementById("issue").value = "<?php echo $issuedate ?>";
          </script>
        </div>
        <br>
        <div class="input-group">
          <span class="input-group-text">Author</span>
          <input type="text" class="form-control" placeholder="Author name" name="author" id="author" value="" required>
          <script>
            document.getElementById("author").value = "<?php echo $author ?>";
          </script>
        </div>
        <br>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Expected Return</span>
          <input type="text" class="form-control" placeholder="Expected return date" name="return" id="return" value="" required>
          <script>
            document.getElementById("return").value = "<?php echo $expected ?>";
          </script>
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Number of available books</span>
          <input type="text" class="form-control" placeholder="number of books on the shelf" name="available" id="available" value="">
          <script>
            document.getElementById("available").value = "<?php echo $availability ?>";
          </script>
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